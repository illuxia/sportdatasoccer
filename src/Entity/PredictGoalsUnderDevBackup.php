<?php

namespace App\Entity;

class PredictGoalsUnderDevBackup
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
            // option 1
            /*
             * handicap - AH 2.5, AH 2.75
             * coefficient - home team odds 2.4 - 2.65
             */
            ($this->awayTeam->getGoalsScored() + $this->homeTeam->getGoalsAgainst() <= 19)
            &&
            ($this->awayTeam->getGoalsScored() + $this->homeTeam->getGoalsAgainst() >= 5)


        )
        {
            return 'UNDER-v1';
        }

        return '';
    }

    public function predictUnderV2()
    {
        if (
            // option 1
            /*
             * handicap - AH 2.5, AH 2.75
             * coefficient - home team odds 2.4 - 2.65
             */
            ($this->awayTeam->getGoalsScored() + $this->homeTeam->getGoalsAgainst() <= 19)
            &&
            ($this->awayTeam->getGoalsScored() + $this->homeTeam->getGoalsAgainst() >= 5)

            &&
            ($this->homeTeam->getGoalsScored() + $this->awayTeam->getGoalsAgainst() <= 15)

            &&
            ($this->homeTeam->getGoalsScored() + $this->awayTeam->getGoalsAgainst() >= 11)


        )
        {
            return 'UNDER-v2';
        }

        return '';
    }





}