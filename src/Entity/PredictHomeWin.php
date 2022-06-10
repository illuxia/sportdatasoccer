<?php

namespace App\Entity;

class PredictHomeWin
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
            // coefficient (1.7 - 2.1)
            // AH - 2, 2.25, 2.5
            $this->awayTeam->getGoalsScored() >= 8 // 7 (8)
            &&
            $this->homeTeam->getGoalsAgainst() <= 5 // 5
            &&
            $this->homeTeam->getGoalsScored() >= 5 // 5 (6)

        )

        {
            return '1-v1';
        }

        return '';
    }


    public function predictHomeWinV2()
    {
        if (
            // option 1
            // coefficient (1.7 - 1.9)
            // AH2.5, AH 2.25
            // 13/17 - 76%
//            ($this->awayTeam->getGoalsScored() >= 9 && $this->homeTeam->getGoalsAgainst() <= 5)
//            && ($this->homeTeam->getGoalsScored() >= 5 || $this->awayTeam->getGoalsAgainst() >= 5)

//            // option 2
//            // coefficient (1.55 - 1.9)
//            // 42/60 - 70%
//            ($this->awayTeam->getGoalsScored() >= 9 && $this->homeTeam->getGoalsAgainst() >= 5)
//            && ($this->homeTeam->getGoalsScored() >= 5 || $this->awayTeam->getGoalsAgainst() >= 5)

            // option 3
            // coefficient (1.55 - 1.9)
            // 29/40 - 73%
//            ($this->awayTeam->getGoalsScored() >= 9 && $this->homeTeam->getGoalsAgainst() <= 5)
//            && ($this->homeTeam->getGoalsScored() >= 5 || $this->awayTeam->getGoalsAgainst() >= 5)

            // option 4
            // coefficient (1.6 - 1.9)
            // goals handicap - AH2.75, AH3, AH3.25 AH3.5
            // 19/27 - 70%
//            ($this->awayTeam->getGoalsScored() >= 9 && $this->homeTeam->getGoalsAgainst() >= 6)
//            && ($this->homeTeam->getGoalsScored() >= 5 || $this->awayTeam->getGoalsAgainst() >= 5)

            // option 5
            // coefficient (1.7 - 1.9)
            // goals handicap - AH2, AH2.25, AH2.5, AH2.75, AH3, AH3.25 AH3.5
            // 41/57 72%

            // TODO clone strategy as over 2.5
            $this->awayTeam->getGoalsScored() >= 8 // 8

            &&

            $this->homeTeam->getGoalsAgainst() <= 9 // 9

            &&

            $this->homeTeam->getGoalsAgainst() <= $this->awayTeam->getGoalsAgainst() + 1 // 1


        )

        {
            return '1-v2';
        }

        return '';
    }

    public function predictHomeWinV3()
    {
        if (
            // option 1
            /*
             * coefficient 1.7 - 1.9
             */
            $this->homeTeam->getGoalsScored() >= $this->awayTeam->getGoalsScored()
            && $this->awayTeam->getGoalsAgainst() >= 6
            && $this->awayTeam->getGoalsScored() <= 2

        )

        {
            return '1-v3';
        }

        return '';
    }

    public function predictHomeWinV4()
    {
        if (
            // option 1
            /*
             * coefficient 1.96 - 2.3
             * goals handicap > AH2.5, AH2.75, AH3, AH3.25 AH3.5
             */
//            ($this->awayTeam->getGoalsScored() >= 9 && $this->homeTeam->getGoalsAgainst() >= 9)
//            && ($this->homeTeam->getGoalsScored() >= 5 || $this->awayTeam->getGoalsAgainst() >= 5)

            // option 2
            /*
             * coefficient 1.96 - 2.3
             * goals handicap > AH2.5, AH2.75, AH3, AH3.25 AH3.5
             */
            ($this->awayTeam->getGoalsScored() >= 9 && $this->homeTeam->getGoalsAgainst() >= 9)
            && ($this->homeTeam->getGoalsScored() <= 7 || $this->awayTeam->getGoalsAgainst() <= 7)

        )

        {
            return '1-v4';
        }

        return '';
    }


    public function predictHomeWinV5()
    {
        if (
            // option 1
            // coefficient (1.7 - 1.9)
            // AH2.5, AH 2.25
            // 13/17 - 76%
//            ($this->awayTeam->getGoalsScored() >= 9 && $this->homeTeam->getGoalsAgainst() <= 5)
//            && ($this->homeTeam->getGoalsScored() >= 5 || $this->awayTeam->getGoalsAgainst() >= 5)

//            // option 2
//            // coefficient (1.55 - 1.9)
//            // 42/60 - 70%
//            ($this->awayTeam->getGoalsScored() >= 9 && $this->homeTeam->getGoalsAgainst() >= 5)
//            && ($this->homeTeam->getGoalsScored() >= 5 || $this->awayTeam->getGoalsAgainst() >= 5)

            // option 3
            // coefficient (1.55 - 1.9)
            // 29/40 - 73%
//            ($this->awayTeam->getGoalsScored() >= 9 && $this->homeTeam->getGoalsAgainst() <= 5)
//            && ($this->homeTeam->getGoalsScored() >= 5 || $this->awayTeam->getGoalsAgainst() >= 5)

            // option 4
            // coefficient (1.6 - 1.9)
            // goals handicap - AH2.75, AH3, AH3.25 AH3.5
            // 19/27 - 70%
            ($this->awayTeam->getGoalsScored() >= 9 && $this->homeTeam->getGoalsAgainst() >= 6)
            && ($this->homeTeam->getGoalsScored() >= 5 || $this->awayTeam->getGoalsAgainst() >= 5)

            // option 5
            // coefficient (1.7 - 1.9)
            // 43/60 72%
//            $this->awayTeam->getGoalsScored() >= 8
//            && $this->homeTeam->getGoalsAgainst() <= $this->awayTeam->getGoalsAgainst() + 1


        )

        {
            return '1-v5';
        }

        return '';
    }

    public function predictHomeWinV6()
    {
        if (
            // option 1
            /*
             * coefficient 1.8 - 1.9
             * goals handicap < 2.75
             */
            ($this->homeTeam->getGoalsScored() + $this->awayTeam->getGoalsAgainst() < 14) // 14
            && ($this->awayTeam->getGoalsScored() + $this->homeTeam->getGoalsAgainst() > 9) // 9
            && $this->awayTeam->getLastGoalsAgainst() <= $this->homeTeam->getLastGoalsAgainst()
        )

        {
            return '1-v6';
        }

        return '';
    }



}