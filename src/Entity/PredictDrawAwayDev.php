<?php

namespace App\Entity;

class PredictDrawAwayDev
{
    private $homeTeam;
    private $awayTeam;

    public function __construct(Team $homeTeam, Team $awayTeam)
    {
        $this->homeTeam = $homeTeam;
        $this->awayTeam = $awayTeam;
    }

    public function predictDrawAwayV1()
    {
        if (
            // option 1
            /*
             * coefficient 1.55 - 1.8
             * goals handicap < 2.75
             */
            ($this->awayTeam->getGoalsScored() + $this->homeTeam->getGoalsAgainst() > 10) // 10
            && ($this->homeTeam->getGoalsScored() + $this->awayTeam->getGoalsAgainst() < 14) // 14
            && $this->awayTeam->getGoalsScored() <= 5 // 5
        )

        {
            return 'X2-v1';
        }

        return '';
    }

    public function predictDrawAwayV2()
    {
        if (
            // option 1
            /*
             * coefficient 1.7 (1.55) - 1.8
             * goals handicap < 2.75
             */
            (($this->homeTeam->getGoalsAgainst() > 6 ) // 6
            && ($this->homeTeam->getGoalsScored() + $this->awayTeam->getGoalsAgainst() < 15)) // 15


        )

        {
            return 'X2-v2';
        }

        return '';
    }


    public function predictDrawAwayV3()
    {
        if (
//            // option 1
//            /*
//             * coefficient 1.6 - 1.9
//             * goals handicap < 2.75
//             */
//            ($this->homeTeam->getGoalsScored() + $this->awayTeam->getGoalsAgainst() < 15) // 15
//            && ($this->awayTeam->getGoalsScored() + $this->homeTeam->getGoalsAgainst() > 12) // 12

            // option 1
            /*
             * coefficient 1.55 (1.7) - 1.8
             * goals handicap < 2.75
             */
            ($this->homeTeam->getGoalsScored() + $this->awayTeam->getGoalsAgainst() < 14) // 14
            && ($this->awayTeam->getGoalsScored() + $this->homeTeam->getGoalsAgainst() > 9) // 9
            && ($this->awayTeam->getLastGoalsAgainst() <= $this->homeTeam->getLastGoalsAgainst() || $this->awayTeam->getGoalsAgainst() <= $this->homeTeam->getGoalsAgainst())
        )

        {
            return 'X2-v3';
        }

        return '';
    }

    public function predictDrawAwayV4()
    {
        if (

            // option 1
            /*
             * coefficient 1.6 - 1.95
             * goals handicap < AH2.5, AH 2.75
             */
            ($this->awayTeam->getGoalsScored() >= 9 && $this->homeTeam->getGoalsAgainst() >= 9)
            && ($this->homeTeam->getGoalsScored() >= 5 || $this->awayTeam->getGoalsAgainst() >= 5)

        )

        {
            return 'X2-v4';
        }

        return '';
    }

    public function predictDrawAwayV5()
    {
        if (

            // option 1
            /*
             * coefficient 1.6 - 1.95
             * goals handicap < AH2.5, AH 2.75
             */
            ($this->awayTeam->getGoalsScored() >= 9 && $this->homeTeam->getGoalsAgainst() >= 9)
            && ($this->homeTeam->getGoalsScored() >= 5 || $this->awayTeam->getGoalsAgainst() >= 5)

        )

        {
            return 'X2-v5';
        }

        return '';
    }

    public function predictDrawAwayV6()
    {
        if (

            // option 1
            /*
             * coefficient 1.55 - 1.7
             */
//            $this->awayTeam->getGoalsScored() >= 8 // 7 (8)
//            &&
//            $this->homeTeam->getGoalsAgainst() <= 5 // 5
//            &&
//            $this->homeTeam->getGoalsScored() >= 5 // 5 (6)
        1 == 1

        )

        {
            return 'X2-v6';
        }

        return '';
    }




}