<?php

namespace App\Entity;

class PredictGoalsOver
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
//            ($this->awayTeam->getGoalsAgainst() <= 5
//            && $this->homeTeam->getGoalsScored() <= 5
//            && $this->homeTeam->getGoalsAgainst() <= 5)
        ($this->homeTeam->getGoalsScored() + $this->awayTeam->getGoalsAgainst() > 19)

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
             * handicap - AH 2.5, AH 2.25
             */
            ($this->awayTeam->getGoalsScored() + $this->homeTeam->getGoalsAgainst() <= 13)
            &&
            ($this->awayTeam->getGoalsScored() + $this->homeTeam->getGoalsAgainst() >= 7)

            &&
            ($this->homeTeam->getGoalsScored() + $this->awayTeam->getGoalsAgainst() <= 16)

            &&
            ($this->homeTeam->getGoalsScored() + $this->awayTeam->getGoalsAgainst() >= 10)

            // option 2
//            ($this->awayTeam->getGoalsScored() + $this->homeTeam->getGoalsAgainst() <= 15)
//            &&
//            ($this->awayTeam->getGoalsScored() + $this->homeTeam->getGoalsAgainst() >= 9) // 6 is optimal


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
             * coefficient 1.2 - 1.55
             * handicap - AH 2.5, AH 2.25, AH 2
             */
//            ($this->awayTeam->getGoalsScored() + $this->homeTeam->getGoalsAgainst() <= 19)
//            &&
//            ($this->awayTeam->getGoalsScored() + $this->homeTeam->getGoalsAgainst() >= 5)
//
//            &&
//            ($this->homeTeam->getGoalsScored() + $this->awayTeam->getGoalsAgainst() <= 15)
//
//            &&
//            ($this->homeTeam->getGoalsScored() + $this->awayTeam->getGoalsAgainst() >= 11)

            // option 2
            ($this->awayTeam->getGoalsScored() + $this->homeTeam->getGoalsAgainst() <= 15)
            &&
            ($this->awayTeam->getGoalsScored() + $this->homeTeam->getGoalsAgainst() >= 9) // 6 is optimal


        )
        {
            return 'OVER-v3';
        }

        return '';
    }






}