<?php

namespace App\Controller;

use App\Entity\PredictDrawAway;
use App\Entity\Team;
use Doctrine\DBAL\Connection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class PredictDrawAwayController extends AbstractController
{
    /**
     * @Route("/draw-away", name="home.draw_away")
     */
    public function predictions(Connection $connection)
    {
        $fixtures = $connection->fetchAllAssociative('SELECT *
                                                            FROM
                                                            (SELECT fx.match_id, r.name as round, fx.match_start, l.league_id, l.name as league_name, c.country_id, c.name as country_name, fx.home_team_id, ht.name as home_team_name, ht.logo as home_team_logo, fx.away_team_id, awt.name as away_team_name, awt.logo as away_team_logo,
                                                                   round(AVG(o.home), 2) as home_odds, round(AVG(o.draw), 2) as draw_odds, round(AVG(o.away), 2) as away_odds, fx.ft_score
                                                            FROM fixture fx
                                                            INNER JOIN league l ON fx.league_id = l.league_id
                                                            INNER JOIN team ht ON fx.home_team_id = ht.team_id
                                                            INNER JOIN team awt ON fx.away_team_id = awt.team_id
                                                            INNER JOIN country c ON l.country_id = c.country_id
                                                            INNER JOIN round r ON fx.round_id = r.round_id
                                                            LEFT JOIN odd o ON fx.match_id = o.fixture_id
                                                            WHERE fx.status_code = 3
                                                            -- AND r.name NOT IN (1,2,3,4,5)
                                                            -- AND l.country_id IN (115)
                                                            -- AND l.country_id NOT IN (114, 115, 55)
                                                            AND o.odd_type = "1X2, Full Time Result"
                                                            AND o.bookmaker_id = 2
                                                            AND DATE(fx.match_start) < "2021-11-01"
                                                            -- AND DATE(fx.match_start) >= "2021-11-01" 
                                                            GROUP BY fx.match_id, fx.match_start, l.league_id, l.name, c.country_id, c.name, fx.home_team_id, ht.name, ht.logo, fx.away_team_id, awt.name, awt.name, awt.logo, fx.ft_score
                                                            ORDER BY DATE(fx.match_start), c.name, l.name) t1
                                                            LEFT JOIN
                                                            (SELECT o.fixture_id, o.handicap, o.goals_over, o.goals_under
                                                            FROM odd o
                                                            WHERE o.bookmaker_id = 2
                                                            AND o.odd_type = "Over/Under, Goal Line") t2
                                                            ON t1.match_id = t2.fixture_id;');

        $predictions = [];
        foreach ($fixtures as $fixture)
        {
            if ($fixture['round'] == 1 || $fixture['round'] == 2 || $fixture['round'] == 3 || $fixture['round'] == 4 || $fixture['round'] == 5)
            {
                continue;
            }

            $homeTeamHistoricFixtures = $connection->prepare('SELECT f.* 
                                                                FROM fixture f, season s
                                                                WHERE f.season_id = s.season_id
                                                                AND f.status_code = 3 
                                                                AND s.is_current = 1
                                                                AND (f.home_team_id = :home_team_id OR f.away_team_id = :home_team_id) 
                                                                AND DATE(f.match_start) < DATE(:match_start_date)
                                                                ORDER BY f.match_start DESC 
                                                                LIMIT 5;')->executeQuery([
                ':home_team_id' => $fixture["home_team_id"],
                ':match_start_date' => $fixture["match_start"]])->fetchAllAssociative();

            $awayTeamHistoricFixtures = $connection->prepare('SELECT f.* 
                                                                FROM fixture f, season s
                                                                WHERE f.season_id = s.season_id
                                                                AND f.status_code = 3 
                                                                AND s.is_current = 1
                                                                AND (f.home_team_id = :away_team_id OR f.away_team_id = :away_team_id) 
                                                                AND DATE(f.match_start) < DATE(:match_start_date)
                                                                ORDER BY f.match_start DESC 
                                                                LIMIT 5;')->executeQuery([
                ':away_team_id' => $fixture["away_team_id"],
                ':match_start_date' => $fixture["match_start"]])->fetchAllAssociative();


            $homeTeamLastHistoricFixtures = $connection->prepare('SELECT f.* 
                                                                FROM fixture f, season s
                                                                WHERE f.season_id = s.season_id
                                                                AND f.status_code = 3 
                                                                AND s.is_current = 1
                                                                AND (f.home_team_id = :home_team_id OR f.away_team_id = :home_team_id) 
                                                                AND DATE(f.match_start) < DATE(:match_start_date)
                                                                ORDER BY f.match_start DESC 
                                                                LIMIT 3;')->executeQuery([
                ':home_team_id' => $fixture["home_team_id"],
                ':match_start_date' => $fixture["match_start"]])->fetchAllAssociative();

            $awayTeamLastHistoricFixtures = $connection->prepare('SELECT f.* 
                                                                FROM fixture f, season s
                                                                WHERE f.season_id = s.season_id
                                                                AND f.status_code = 3 
                                                                AND s.is_current = 1
                                                                AND (f.home_team_id = :away_team_id OR f.away_team_id = :away_team_id) 
                                                                AND DATE(f.match_start) < DATE(:match_start_date)
                                                                ORDER BY f.match_start DESC 
                                                                LIMIT 3;')->executeQuery([
                ':away_team_id' => $fixture["away_team_id"],
                ':match_start_date' => $fixture["match_start"]])->fetchAllAssociative();




            $homeTeam = new Team($fixture["home_team_id"]);
            $awayTeam = new Team($fixture["away_team_id"]);

            /*
             * Set teams data
             */
            foreach ($homeTeamHistoricFixtures as $homeTeamHistoricFixture)
            {
                if ($homeTeamHistoricFixture['home_team_id'] == $homeTeam->getTeamId())
                {
                    $homeTeam->addGoalsScored($homeTeamHistoricFixture['home_score']);
                    $homeTeam->addGoalsAgainst($homeTeamHistoricFixture['away_score']);
                } else
                {
                    $homeTeam->addGoalsScored($homeTeamHistoricFixture['away_score']);
                    $homeTeam->addGoalsAgainst($homeTeamHistoricFixture['home_score']);
                }
            }

            foreach ($awayTeamHistoricFixtures as $awayTeamHistoricFixture)
            {
                if ($awayTeamHistoricFixture['home_team_id'] == $awayTeam->getTeamId())
                {
                    $awayTeam->addGoalsScored($awayTeamHistoricFixture['home_score']);
                    $awayTeam->addGoalsAgainst($awayTeamHistoricFixture['away_score']);
                } else
                {
                    $awayTeam->addGoalsScored($awayTeamHistoricFixture['away_score']);
                    $awayTeam->addGoalsAgainst($awayTeamHistoricFixture['home_score']);
                }
            }

            foreach ($homeTeamLastHistoricFixtures as $homeTeamLastHistoricFixture)
            {
                if ($homeTeamLastHistoricFixture['home_team_id'] == $homeTeam->getTeamId())
                {
                    $homeTeam->addLastGoalsScored($homeTeamLastHistoricFixture['home_score']);
                    $homeTeam->addLastGoalsAgainst($homeTeamLastHistoricFixture['away_score']);
                } else
                {
                    $homeTeam->addLastGoalsScored($homeTeamLastHistoricFixture['away_score']);
                    $homeTeam->addLastGoalsAgainst($homeTeamLastHistoricFixture['home_score']);
                }
            }

            foreach ($awayTeamLastHistoricFixtures as $awayTeamLastHistoricFixture)
            {
                if ($awayTeamLastHistoricFixture['home_team_id'] == $awayTeam->getTeamId())
                {
                    $awayTeam->addLastGoalsScored($awayTeamLastHistoricFixture['home_score']);
                    $awayTeam->addLastGoalsAgainst($awayTeamLastHistoricFixture['away_score']);
                } else
                {
                    $awayTeam->addLastGoalsScored($awayTeamLastHistoricFixture['away_score']);
                    $awayTeam->addLastGoalsAgainst($awayTeamLastHistoricFixture['home_score']);
                }
            }

            /*
             * Start prediction
             */
            $prediction = new PredictDrawAway($homeTeam, $awayTeam);

            if (
                $prediction->predictDrawAwayV1() != '' && ($fixture['home_odds'] >= 1.55 && $fixture['home_odds'] <= 1.9 && ($fixture['handicap'] != "3" && $fixture['handicap'] != "3.0" && $fixture['handicap'] != "2.5,3.0" && $fixture['handicap'] != "2.75" && $fixture['handicap'] != "3.0,3.5" && $fixture['handicap'] != "3.25" && $fixture['handicap'] != "3.5" ))
                || $prediction->predictDrawAwayV2() != '' && ($fixture['home_odds'] >= 1.7 && $fixture['home_odds'] <= 1.9 && ($fixture['handicap'] != "3" && $fixture['handicap'] != "3.0" && $fixture['handicap'] != "2.5,3.0" && $fixture['handicap'] != "2.75" && $fixture['handicap'] != "3.0,3.5" && $fixture['handicap'] != "3.25" && $fixture['handicap'] != "3.5" ))
                || $prediction->predictDrawAwayV3() != '' && ($fixture['home_odds'] >= 1.6 && $fixture['home_odds'] <= 1.9 && ($fixture['handicap'] != "3" && $fixture['handicap'] != "3.0" && $fixture['handicap'] != "2.5,3.0" && $fixture['handicap'] != "2.75" && $fixture['handicap'] != "3.0,3.5" && $fixture['handicap'] != "3.25" && $fixture['handicap'] != "3.5" ))
                || $prediction->predictDrawAwayV4() != '' && ($fixture['home_odds'] >= 1.6 && $fixture['home_odds'] <= 1.95 && ($fixture['handicap'] != "3" && $fixture['handicap'] != "3.0" && $fixture['handicap'] != "2.5,3.0" && $fixture['handicap'] != "2.75" && $fixture['handicap'] != "3.0,3.5" && $fixture['handicap'] != "3.25" && $fixture['handicap'] != "3.5" ))
                || $prediction->predictDrawAwayV5() != '' && ($fixture['home_odds'] >= 1.6 && $fixture['home_odds'] <= 1.95 && ($fixture['handicap'] == "2.5" || $fixture['handicap'] == "2.5,3.0" || $fixture['handicap'] == "2.75" ))

            )
            {

                $finalScore = (explode("-",$fixture['ft_score']));

                $predictDrawAwayV1 = ($prediction->predictDrawAwayV1() != '' && ($fixture['home_odds'] >= 1.55 && $fixture['home_odds'] <= 1.9) && ($fixture['handicap'] != "3" && $fixture['handicap'] != "3.0" && $fixture['handicap'] != "2.5,3.0" && $fixture['handicap'] != "2.75" && $fixture['handicap'] != "3.0,3.5" && $fixture['handicap'] != "3.25" && $fixture['handicap'] != "3.5" ) ) ? $prediction->predictDrawAwayV1() : '';
                $predictDrawAwayV2 = ($prediction->predictDrawAwayV2() != '' && ($fixture['home_odds'] >= 1.7 && $fixture['home_odds'] <= 1.9) && ($fixture['handicap'] != "3" && $fixture['handicap'] != "3.0" && $fixture['handicap'] != "2.5,3.0" && $fixture['handicap'] != "2.75" && $fixture['handicap'] != "3.0,3.5" && $fixture['handicap'] != "3.25" && $fixture['handicap'] != "3.5" )) ? $prediction->predictDrawAwayV2() : '';
                $predictDrawAwayV3 = ($prediction->predictDrawAwayV3() != '' && ($fixture['home_odds'] >= 1.6 && $fixture['home_odds'] <= 1.9) && ($fixture['handicap'] != "3" && $fixture['handicap'] != "3.0" && $fixture['handicap'] != "2.5,3.0" && $fixture['handicap'] != "2.75" && $fixture['handicap'] != "3.0,3.5" && $fixture['handicap'] != "3.25" && $fixture['handicap'] != "3.5" )) ? $prediction->predictDrawAwayV3() : '';
                $predictDrawAwayV4 = ($prediction->predictDrawAwayV4() != '' && ($fixture['home_odds'] >= 1.6 && $fixture['home_odds'] <= 1.95) && ($fixture['handicap'] != "3" && $fixture['handicap'] != "3.0" && $fixture['handicap'] != "2.5,3.0" && $fixture['handicap'] != "2.75" && $fixture['handicap'] != "3.0,3.5" && $fixture['handicap'] != "3.25" && $fixture['handicap'] != "3.5" )) ? $prediction->predictDrawAwayV4() : '';
                $predictDrawAwayV5 = ($prediction->predictDrawAwayV5() != '' && ($fixture['home_odds'] >= 1.6 && $fixture['home_odds'] <= 1.95) && ($fixture['handicap'] == "2.5" || $fixture['handicap'] == "2.5,3.0" || $fixture['handicap'] == "2.75" )) ? $prediction->predictDrawAwayV5() : '';

                array_push($predictions, [
                    'match_id' => $fixture['match_id'],
                    'match_start' => $fixture['match_start'],
                    'round' => $fixture['round'],
                    'country_name' => $fixture['country_name'],
                    'league_name' => $fixture['league_name'],
                    'home_team_name' => $fixture['home_team_name'],
                    'away_team_name' => $fixture['away_team_name'],
                    'home_odds' => $fixture['home_odds'],
                    'draw_odds' => $fixture['draw_odds'],
                    'away_odds' => $fixture['away_odds'],
                    'score' => $fixture['ft_score'],
                    'handicap' => $fixture['handicap'],
                    'goals_over' => $fixture['goals_over'],
                    'goals_under' => $fixture['goals_under'],
                    'home_score' => $finalScore[0],
                    'away_score' => $finalScore[1],
                    'prediction_draw_away_V1' => $predictDrawAwayV1,
                    'prediction_draw_away_V2' => $predictDrawAwayV2,
                    'prediction_draw_away_V3' => $predictDrawAwayV3,
                    'prediction_draw_away_V4' => $predictDrawAwayV4,
                    'prediction_draw_away_V5' => $predictDrawAwayV5
                ]);
            }


        }

        return $this->render('predict_draw_away.html.twig', [
            'predictions' => $predictions
        ]);
    }

}