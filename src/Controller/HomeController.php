<?php

namespace App\Controller;

use App\Entity\Prediction;
use App\Entity\Team;
use Doctrine\DBAL\Connection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home.index")
     */
    public function index(Connection $connection)
    {
        $fixtures = $connection->fetchAllAssociative('SELECT fx.match_id, fx.match_start, l.league_id, l.name as league_name, c.country_id, c.name as country_name, fx.home_team_id, ht.name as home_team_name, ht.logo as 		   home_team_logo, fx.away_team_id, awt.name as away_team_name, awt.name as away_team_name, awt.logo as away_team_logo, 
                                                                   round(AVG(o.home), 2) as home_odds, round(AVG(o.draw), 2) as draw_odds, round(AVG(o.away), 2) as away_odds,
                                                                   IF(o.handicap = "2.5" OR o.handicap = "2.50", round(AVG(o.goals_over), 2), null) as goals_over, 
                                                                   IF(o.handicap = "2.5" OR o.handicap = "2.50", round(AVG(o.goals_under), 2), null) as goals_under
                                                            FROM fixture fx INNER JOIN league l ON fx.league_id = l.league_id 
                                                            INNER JOIN team ht ON fx.home_team_id = ht.team_id 
                                                            INNER JOIN team awt ON fx.away_team_id = awt.team_id 
                                                            INNER JOIN country c ON l.country_id = c.country_id 
                                                            LEFT JOIN (SELECT *
                                                                      FROM odd od
                                                                      WHERE od.odd_type = "1X2, Full Time Result" 
                                                                      OR od.odd_type = "Over/Under, Goal Line") o ON fx.match_id = o.fixture_id 
                                                            WHERE fx.status_code = 0
                                                            -- AND o.bookmaker_id = 2
                                                            -- AND DATE(fx.match_start) < "2021-11-01"
                                                            AND fx.match_start BETWEEN (NOW() - INTERVAL 15 DAY) AND (NOW() + INTERVAL 5 DAY) 

                                                            GROUP BY fx.match_id, fx.match_start, l.league_id, l.name, c.country_id, c.name, fx.home_team_id, ht.name, ht.logo, fx.away_team_id, awt.name, awt.name, awt.logo 
                                                            ORDER BY fx.match_start, c.name, l.name;');
//        dd($fixtures);
        return $this->render('home.html.twig', [
            'fixtures' => $fixtures
        ]);
    }

    /**
     * @Route("/predictions", name="home.predictions")
     */
    public function predictions(Connection $connection)
    {
//        $fixtures = $connection->fetchAllAssociative('SELECT fx.match_id, fx.match_start, l.league_id, l.name as league_name, c.country_id, c.name as country_name, fx.home_team_id, ht.name as home_team_name, ht.logo as 		   home_team_logo, fx.away_team_id, awt.name as away_team_name, awt.name as away_team_name, awt.logo as away_team_logo,
//                                                                   round(AVG(o.home), 2) as home_odds, round(AVG(o.draw), 2) as draw_odds, round(AVG(o.away), 2) as away_odds,
//                                                                   IF(o.handicap = "2.5" OR o.handicap = "2.50", round(AVG(o.goals_over), 2), null) as goals_over,
//                                                                   IF(o.handicap = "2.5" OR o.handicap = "2.50", round(AVG(o.goals_under), 2), null) as goals_under
//                                                            FROM fixture fx
//                                                            INNER JOIN league l ON fx.league_id = l.league_id
//                                                            INNER JOIN team ht ON fx.home_team_id = ht.team_id
//                                                            INNER JOIN team awt ON fx.away_team_id = awt.team_id
//                                                            INNER JOIN country c ON l.country_id = c.country_id
//                                                            LEFT JOIN odd o ON fx.match_id = o.fixture_id
//                                                            WHERE fx.status_code = 0
//                                                            AND (o.odd_type = "1X2, Full Time Result" OR o.odd_type = "Over/Under, Goal Line")
//                                                            AND fx.match_start BETWEEN (NOW() - INTERVAL 1 DAY) AND (NOW() + INTERVAL 5 DAY)
//                                                            GROUP BY fx.match_id, fx.match_start, l.league_id, l.name, c.country_id, c.name, fx.home_team_id, ht.name, ht.logo, fx.away_team_id, awt.name, awt.name, awt.logo
//                                                            ORDER BY c.name, l.name, DATE(fx.match_start);');


        $fixtures = $connection->fetchAllAssociative('SELECT fx.match_id, r.name as round, fx.match_start, l.league_id, l.name as league_name, c.country_id, c.name as country_name, fx.home_team_id, ht.name as home_team_name, ht.logo as 		   home_team_logo, fx.away_team_id, awt.name as away_team_name, awt.name as away_team_name, awt.logo as away_team_logo,
                                                                   round(AVG(o.home), 2) as home_odds, round(AVG(o.draw), 2) as draw_odds, round(AVG(o.away), 2) as away_odds,
                                                                   IF(o.handicap = "2.5" OR o.handicap = "2.50", round(AVG(o.goals_over), 2), null) as goals_over,
                                                                   IF(o.handicap = "2.5" OR o.handicap = "2.50", round(AVG(o.goals_under), 2), null) as goals_under,
                                                                    fx.ft_score
                                                            FROM fixture fx
                                                            INNER JOIN league l ON fx.league_id = l.league_id
                                                            INNER JOIN team ht ON fx.home_team_id = ht.team_id
                                                            INNER JOIN team awt ON fx.away_team_id = awt.team_id
                                                            INNER JOIN country c ON l.country_id = c.country_id
                                                            INNER JOIN round r ON fx.round_id = r.round_id
                                                            LEFT JOIN odd o ON fx.match_id = o.fixture_id
                                                            WHERE fx.status_code = 3
                                                            AND r.name NOT IN (1,2,3,4,5)
                                                            AND l.country_id NOT IN (114)
                                                            AND (o.odd_type = "1X2, Full Time Result" OR o.odd_type = "Over/Under, Goal Line")
                                                            AND DATE(fx.match_start) < "2021-11-01"
                                                            GROUP BY fx.match_id, fx.match_start, l.league_id, l.name, c.country_id, c.name, fx.home_team_id, ht.name, ht.logo, fx.away_team_id, awt.name, awt.name, awt.logo
                                                            ORDER BY DATE(fx.match_start), c.name, l.name;');

        $predictions = [];
        foreach ($fixtures as $fixture)
        {
            $homeTeamHistoricFixtures = $connection->prepare('SELECT f.* 
                                                                FROM fixture f, season s
                                                                WHERE f.season_id = s.season_id
                                                                AND f.status_code = 3 
                                                                AND s.is_current = 1
                                                                AND (f.home_team_id = :home_team_id OR f.away_team_id = :home_team_id) 
                                                                ORDER BY f.match_start DESC 
                                                                LIMIT 5;')->executeQuery([
                                                                    ':home_team_id' => $fixture["home_team_id"]])->fetchAllAssociative();

            $awayTeamHistoricFixtures = $connection->prepare('SELECT f.* 
                                                                FROM fixture f, season s
                                                                WHERE f.season_id = s.season_id
                                                                AND f.status_code = 3 
                                                                AND s.is_current = 1
                                                                AND (f.home_team_id = :away_team_id OR f.away_team_id = :away_team_id) 
                                                                ORDER BY f.match_start DESC 
                                                                LIMIT 5;')->executeQuery([
                                                                    ':away_team_id' => $fixture["away_team_id"]])->fetchAllAssociative();

            // <added on=16.11.2021>
            $homeTeamLastHistoricFixtures = $connection->prepare('SELECT f.* 
                                                                FROM fixture f, season s
                                                                WHERE f.season_id = s.season_id
                                                                AND f.status_code = 3 
                                                                AND s.is_current = 1
                                                                AND (f.home_team_id = :home_team_id OR f.away_team_id = :home_team_id) 
                                                                ORDER BY f.match_start DESC 
                                                                LIMIT 3;')->executeQuery([
                ':home_team_id' => $fixture["home_team_id"]])->fetchAllAssociative();

            $awayTeamLastHistoricFixtures = $connection->prepare('SELECT f.* 
                                                                FROM fixture f, season s
                                                                WHERE f.season_id = s.season_id
                                                                AND f.status_code = 3 
                                                                AND s.is_current = 1
                                                                AND (f.home_team_id = :away_team_id OR f.away_team_id = :away_team_id) 
                                                                ORDER BY f.match_start DESC 
                                                                LIMIT 3;')->executeQuery([
                ':away_team_id' => $fixture["away_team_id"]])->fetchAllAssociative();

            // </added>


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

            // <added on=16.11.2021>
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
            // </added>

            /*
             * Start prediction
             */
            $prediction = new Prediction($homeTeam, $awayTeam);

            if (
                ($prediction->predictUnderV1() != '' && ($fixture['home_odds'] >= 1.5 && $fixture['home_odds'] <= 2.3))
                || ($prediction->predictUnderV2() != '' /*&& ($fixture['home_odds'] >= 1.5 && $fixture['home_odds'] <= 2.3)*/)
                || ($prediction->predictOverV1() != '' /*&& ($fixture['home_odds'] >= 1.5)*/)
                || ($prediction->predictOverV2() != '' /*&& ($fixture['home_odds'] >= 1.5)*/)
                || ($prediction->predictHomeWinV1() != '' /*&& ($fixture['home_odds'] > 1.4)*/)
                || ($prediction->predictDrawAwayV1() != '' && ($fixture['home_odds'] >= 1.5 && $fixture['home_odds'] <= 1.9))
            )
            {
//                if ($fixture['home_odds'] < 1.5 || $fixture['home_odds'] > 3.1)
//                {
//                    continue;
//                }
//                if ($fixture['home_odds'] < 1.5)
//                {
//                    continue;
//                }

                $finalScore = (explode("-",$fixture['ft_score']));

                $predictUnderV1 = ($prediction->predictUnderV1() != '' && ($fixture['home_odds'] >= 1.5 && $fixture['home_odds'] <= 2.3)) ? $prediction->predictUnderV1() : '';
                $predictUnderV2 = ($prediction->predictUnderV2() != '' /*&& ($fixture['home_odds'] >= 1.5 && $fixture['home_odds'] <= 2.3)*/) ? $prediction->predictUnderV2() : '';
                $predictOverV1 = ($prediction->predictOverV1() != '' /*&& ($fixture['home_odds'] >= 1.5)*/) ? $prediction->predictOverV1() : '';
                $predictOverV2 = ($prediction->predictOverV2() != '' /*&& ($fixture['home_odds'] >= 1.5)*/) ? $prediction->predictOverV2() : '';
                $predictHomeWinV1 = ($prediction->predictHomeWinV1() != '' /*&& ($fixture['home_odds'] > 1.4)*/) ? $prediction->predictHomeWinV1() : '';
                $predictDrawAwayV1 = ($prediction->predictDrawAwayV1() != '' && ($fixture['home_odds'] >= 1.5 && $fixture['home_odds'] <= 1.9)) ? $prediction->predictDrawAwayV1() : '';

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
                    'home_score' => $finalScore[0],
                    'away_score' => $finalScore[1],
                    'prediction_under_V1' => $predictUnderV1,
                    'prediction_under_V2' => $predictUnderV2,
                    'prediction_over_V1' => $predictOverV1,
                    'prediction_over_V2' => $predictOverV2,
                    'prediction_home_win_V1' => $predictHomeWinV1,
                    'prediction_draw_away_V1' => $predictDrawAwayV1
                ]);
            }


//
//                if ($prediction->predictFinalResultV1() != '')
//                {
//                    $connection->prepare('INSERT INTO prediction(match_id, prediction_type, creation_date)
//                                          VALUES(:match_id, :prediction_type, now())
//                                          ON DUPLICATE KEY UPDATE
//                                          prediction_type = :prediction_type,
//                                          update_date = now()')->executeQuery([
//                        ':match_id' => $fixture["match_id"],
//                        ':prediction_type' => $prediction->predictFinalResultV1()
//                    ]);
//                }
//
//                if ($prediction->predictGoalsV1() != '')
//                {
//                    $connection->prepare('INSERT INTO prediction(match_id, prediction_type, creation_date)
//                                          VALUES(:match_id, :prediction_type, now())
//                                          ON DUPLICATE KEY UPDATE
//                                          prediction_type = :prediction_type,
//                                          update_date = now()')->executeQuery([
//                        ':match_id' => $fixture["match_id"],
//                        ':prediction_type' => $prediction->predictGoalsV1()
//                    ]);
//                }
//
//            }

        }

        return $this->render('predictions.html.twig', [
            'predictions' => $predictions
        ]);
    }

}