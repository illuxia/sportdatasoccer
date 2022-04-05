<?php

namespace App\Entity;

class PredictionFinal
{
    private $homeTeam;
    private $awayTeam;

    public function __construct(Team $homeTeam, Team $awayTeam)
    {
        $this->homeTeam = $homeTeam;
        $this->awayTeam = $awayTeam;
    }

//    public function predictUnderV1()
//    {
//        if (
//        (($this->awayTeam->getGoalsAgainst() <= 5
//            && $this->homeTeam->getGoalsScored() <= 5
//            && $this->homeTeam->getGoalsAgainst() <= 5))
//
//        )
//        {
//            return 'UNDER-v1';
//        }
//
//        return '';
//    }
//
//    public function predictUnderV2()
//    {
//        if (
//            // option 1
////            (($this->awayTeam->getGoalsAgainst() <= 5 && $this->homeTeam->getGoalsAgainst() <= 5)
////                && ($this->homeTeam->getGoalsScored() <= 5 || $this->awayTeam->getGoalsScored() <= 5))
////
////            &&
////            (($this->homeTeam->getGoalsScored() + $this->awayTeam->getGoalsAgainst() < 11)
////                && ($this->awayTeam->getGoalsScored() + $this->homeTeam->getGoalsAgainst() < 11))
//
//            // option 2
//        (($this->homeTeam->getGoalsScored() + $this->awayTeam->getGoalsAgainst() < 10)
//            && ($this->awayTeam->getGoalsScored() + $this->homeTeam->getGoalsAgainst() < 10))
//        )
//        {
//            return 'UNDER-v2';
//        }
//
//        return '';
//    }
//
//    public function predictOverV1()
//    {
//        if (
//            //option 1
////            ($this->awayTeam->getGoalsScored() >= 8 && $this->homeTeam->getGoalsAgainst() >= 8)
////            && ($this->homeTeam->getGoalsScored() >= 5 || $this->awayTeam->getGoalsAgainst() >= 5)
////
////            &&
////
////            (($this->awayTeam->getGoalsScored() + $this->homeTeam->getGoalsAgainst() > 17)
////                && ($this->homeTeam->getGoalsScored() + $this->awayTeam->getGoalsAgainst() > 13))
//
//            // option 2
//            ($this->awayTeam->getGoalsScored() >= 9 && $this->homeTeam->getGoalsAgainst() >= 9)
//            && ($this->homeTeam->getGoalsScored() >= 5 || $this->awayTeam->getGoalsAgainst() >= 5)
//
//            &&
//
//            (($this->awayTeam->getGoalsScored() + $this->homeTeam->getGoalsAgainst() > 17)
//                && ($this->homeTeam->getGoalsScored() + $this->awayTeam->getGoalsAgainst() < 11))
//
//
//
//        )
//        {
//            return 'OVER-v1';
//        }
//
//        return '';
//    }
//
//    public function predictOverV2()
//    {
//        if (
//            // option 1
//            (($this->homeTeam->getGoalsScored() >= 5 && $this->awayTeam->getGoalsAgainst() >= 5)
//                && ($this->awayTeam->getGoalsScored() >= 5 || $this->homeTeam->getGoalsAgainst() >= 5))
//
//            &&
//            (($this->homeTeam->getGoalsScored() + $this->awayTeam->getGoalsAgainst() > 17)
//                && ($this->awayTeam->getGoalsScored() + $this->homeTeam->getGoalsAgainst() < 11))
//            &&
//            ($this->awayTeam->getLastGoalsAgainst() >= 4)
//
//            // option 2
////        (($this->homeTeam->getGoalsScored() >= 8 && $this->awayTeam->getGoalsAgainst() >= 8)
////            && ($this->awayTeam->getGoalsScored() >= 8 && $this->homeTeam->getGoalsAgainst() >= 8))
//
//
//            // option 3
////            (($this->homeTeam->getGoalsScored() + $this->awayTeam->getGoalsAgainst() > 17)
////                && ($this->awayTeam->getGoalsScored() + $this->homeTeam->getGoalsAgainst() < 11))
//
//
//
//        )
//        {
//            return 'OVER-v2';
//        }
//
//        return '';
//    }
//
//    public function predictHomeWinV1()
//    {
//        if (
//            ($this->homeTeam->getGoalsScored() + $this->awayTeam->getGoalsAgainst() > 17)
//            && ($this->awayTeam->getGoalsScored() + $this->homeTeam->getGoalsAgainst() < 11)
//        )
//
//        {
//            return '1-v1';
//        }
//
//        return '';
//    }
//
//    public function predictDrawAwayV1()
//    {
//        if (
//        (($this->homeTeam->getGoalsAgainst() > 4 )
//            && ($this->homeTeam->getGoalsScored() + $this->awayTeam->getGoalsAgainst() < 16))
//
//
////        (($this->awayTeam->getGoalsScored() + $this->homeTeam->getGoalsAgainst() > 10)
////            && ($this->homeTeam->getGoalsScored() + $this->awayTeam->getGoalsAgainst() < 14))
////
////        (($this->awayTeam->getGoalsScored() + $this->homeTeam->getGoalsAgainst() > 14)
////            && ($this->homeTeam->getGoalsScored() + $this->awayTeam->getGoalsAgainst() < 12))
//
//        )
//
//        {
//            return 'X2-v1';
//        }
//
//        return '';
//    }









    public function predictUnderV1()
    {
        if (
        ($this->awayTeam->getGoalsAgainst() <= 6
            && $this->homeTeam->getGoalsScored() <= 5
            && $this->homeTeam->getGoalsAgainst() <= 6)

        )
        {
            return 'UNDER-v1';
        }

        return '';
    }

    public function predictUnderV2()
    {
        if (

            (($this->awayTeam->getGoalsAgainst() <= 5 && $this->homeTeam->getGoalsAgainst() <= 5)
                && ($this->homeTeam->getGoalsScored() <= 5 || $this->awayTeam->getGoalsScored() <= 5))

            &&
            (($this->homeTeam->getGoalsScored() + $this->awayTeam->getGoalsAgainst() < 12)
                && ($this->awayTeam->getGoalsScored() + $this->homeTeam->getGoalsAgainst() < 12))

//            (($this->awayTeam->getGoalsAgainst() <= 5 && $this->homeTeam->getGoalsAgainst() <= 5)
//            && ($this->homeTeam->getGoalsScored() <= 5 && $this->awayTeam->getGoalsScored() <= 5))
        )
        {
            return 'UNDER-v2';
        }

        return '';
    }

    public function predictOverV1()
    {

        if (
            // option 1 - 1 (1.55 - 1.95) AH2.5, AH 2.75
//            ($this->awayTeam->getGoalsScored() >= 9 && $this->homeTeam->getGoalsAgainst() >= 5)
//            && ($this->homeTeam->getGoalsScored() >= 5 || $this->awayTeam->getGoalsAgainst() >= 5)

            // option 2 - X2 (1.6 - 1.95) AH2.5, AH 2.25
            ($this->awayTeam->getGoalsScored() >= 9 && $this->homeTeam->getGoalsAgainst() >= 9)
            && ($this->homeTeam->getGoalsScored() >= 5 || $this->awayTeam->getGoalsAgainst() >= 5)

        )
        {
            return 'OVER-v1';
        }

        return '';
    }

    public function predictOverV2()
    {
        if (
//            (($this->homeTeam->getGoalsScored() >= 7 && $this->awayTeam->getGoalsAgainst() >= 7)
//                && ($this->awayTeam->getGoalsScored() >= 7 || $this->homeTeam->getGoalsAgainst() >= 7))
//
//            &&
//            (($this->homeTeam->getGoalsScored() + $this->awayTeam->getGoalsAgainst() > 15)
//                && ($this->awayTeam->getGoalsScored() + $this->homeTeam->getGoalsAgainst() > 15))

        (($this->homeTeam->getGoalsScored() >= 8 && $this->awayTeam->getGoalsAgainst() >= 8)
            && ($this->awayTeam->getGoalsScored() >= 8 && $this->homeTeam->getGoalsAgainst() >= 8))


        )
        {
            return 'OVER-v2';
        }

        return '';
    }

    public function predictHomeWinV1()
    {
        if (
            // option 1
            ($this->homeTeam->getGoalsScored() + $this->awayTeam->getGoalsAgainst() < 15)
            && ($this->awayTeam->getGoalsScored() + $this->homeTeam->getGoalsAgainst() > 12)

        )

        {
            return '1-v1';
        }

        return '';
    }

    public function predictDrawAwayV1()
    {
        if (
        (($this->awayTeam->getGoalsScored() + $this->homeTeam->getGoalsAgainst() > 14)
            && ($this->homeTeam->getGoalsScored() + $this->awayTeam->getGoalsAgainst() < 12))
        )

        {
            return 'X2-v1';
        }

        return '';
    }






}