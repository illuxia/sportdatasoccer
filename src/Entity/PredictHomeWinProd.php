<?php

namespace App\Entity;

class PredictHomeWinProd
{
    private $homeTeam;
    private $awayTeam;

    public function __construct(Team $homeTeam, Team $awayTeam)
    {
        $this->homeTeam = $homeTeam;
        $this->awayTeam = $awayTeam;
    }


    public function predictHomeWinV1()
    {
        if (
            // option 1
            /*
             * coefficient 1.2 - 1.6
             * handicap - AH 2.5, AH 2.25, AH 2.0
             */
            ($this->awayTeam->getGoalsScored() + $this->homeTeam->getGoalsAgainst() <= 13) // 13
            &&
            ($this->awayTeam->getGoalsScored() + $this->homeTeam->getGoalsAgainst() >= 7) // 7

            &&
            ($this->homeTeam->getGoalsScored() + $this->awayTeam->getGoalsAgainst() <= 16) // 16

            &&
            ($this->homeTeam->getGoalsScored() + $this->awayTeam->getGoalsAgainst() >= 10) // 10

            &&
            ($this->homeTeam->getGoalsAgainst() > $this->awayTeam->getGoalsAgainst()
                ||
                $this->homeTeam->getGoalsScored() > $this->awayTeam->getGoalsScored())


        )
        {
            return 'OVER-v2';
        }

        return '';
    }






}