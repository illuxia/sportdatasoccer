<?php

namespace App\Entity;

class PredictGoalsOverDev
{
    private $homeTeam;
    private $awayTeam;

    public function __construct(Team $homeTeam, Team $awayTeam)
    {
        $this->homeTeam = $homeTeam;
        $this->awayTeam = $awayTeam;
    }


    public function predictOverV1()
    {
        if (
            /*
             * coefficient 1.2 - 2.15
             * handicap - AH 2.5
             */
            ($this->homeTeam->getGoalsScored() + $this->awayTeam->getGoalsAgainst() > 17) // 17
            &&
            ($this->awayTeam->getGoalsScored() + $this->homeTeam->getGoalsAgainst() < 11) // 11

        )
        {
            return 'OVER-v1';
        }

        return '';
    }

    public function predictOverV2()
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

    public function predictOverV3()
    {
        if (
            // option 1
            /*
             * coefficient 1.2 - 1.7 (1.2 - 1.55)
             * handicap - AH 2.5, AH 2.25, AH 2.0
             */


            $this->awayTeam->getLastGoalsScored() <= 1

            &&

            ($this->homeTeam->getLastGoalsScored() > $this->awayTeam->getLastGoalsScored()
            ||
            $this->homeTeam->getLastGoalsScored() > $this->awayTeam->getLastGoalsAgainst()
            ||
            $this->homeTeam->getGoalsScored() > $this->awayTeam->getGoalsScored())

        )
        {
            return 'OVER-v3';
        }

        return '';
    }

    public function predictOverV4()
    {
        if (
            // option 1
            /*
             * coefficient 1.75 - 1.95
             * goals handicap - AH 2.5, AH 2.25, AH 2
             */

            $this->homeTeam->getGoalsScored() > 9 // 9
            &&
            $this->homeTeam->getLastGoalsScored() > 3 // 3

        )

        {
            return 'OVER-v4';
        }

        return '';
    }






}