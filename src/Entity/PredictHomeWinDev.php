<?php

namespace App\Entity;

class PredictHomeWinDev
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
            // coefficient (1.6 - 1.9)
            // goals handicap - AH2.75, AH3, AH3.25 AH3.5
            ($this->awayTeam->getGoalsScored() >= 9 && $this->homeTeam->getGoalsAgainst() <= 5)
            && ($this->homeTeam->getGoalsScored() >= 5 || $this->awayTeam->getGoalsAgainst() >= 5)

        )

        {
            return '1-v4';
        }

        return '';
    }


    public function predictHomeWinV5()
    {
        if (
            // coefficient (1.6 - 1.9)
            // goals handicap - AH2.75, AH3, AH3.25 AH3.5

            ($this->awayTeam->getGoalsScored() >= 9 && $this->homeTeam->getGoalsAgainst() >= 6)
            && ($this->homeTeam->getGoalsScored() >= 5 || $this->awayTeam->getGoalsAgainst() >= 5)

        )

        {
            return '1-v5';
        }

        return '';
    }



}