<?php

namespace App\Entity;

class PredictGoalsUnder
{
    private $homeTeam;
    private $awayTeam;

    public function __construct(Team $homeTeam, Team $awayTeam)
    {
        $this->homeTeam = $homeTeam;
        $this->awayTeam = $awayTeam;
    }


    public function predictUnderV1()
    {
        if (
            /*
             * handicap - AH 2.5
             * coefficient - home team odds 2.2 - 2.65
             */

            $this->awayTeam->getGoalsAgainst() >= 5 // 5

            &&

            $this->homeTeam->getGoalsAgainst() >= 5 // 5

            &&

            ($this->homeTeam->getGoalsScored() > $this->awayTeam->getGoalsScored()
            ||
            ($this->homeTeam->getLastGoalsScored() + $this->awayTeam->getLastGoalsAgainst() + 2) < ($this->awayTeam->getLastGoalsScored() + $this->homeTeam->getLastGoalsAgainst()))




        )
        {
            return 'UNDER-v1';
        }

        return '';
    }

    public function predictUnderV2()
    {
        if (
            /*
             * handicap - AH 2.5
             * coefficient - home team odds 2.2 - 2.65
             */

            $this->awayTeam->getLastGoalsScored() >= 2 // 2
            &&
            $this->homeTeam->getLastGoalsScored() >= 2 // 2

            &&

            $this->homeTeam->getLastGoalsAgainst() >= $this->awayTeam->getLastGoalsAgainst()

//            &&
//
//            $this->homeTeam->getGoalsScored() > $this->awayTeam->getGoalsScored() + 1


        )
        {
            return 'UNDER-v2';
        }

        return '';
    }





}