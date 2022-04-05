<?php

namespace App\Entity;

class Team
{
    private $team_id;
    private $goalsScored = 0;
    private $goalsAgainst = 0;
    private $lastGoalsScored = 0;
    private $lastGoalsAgainst = 0;

    public function __construct(int $team_id)
    {
        $this->team_id = $team_id;
    }

    /**
     * @return int
     */
    public function getTeamId(): int
    {
        return $this->team_id;
    }

    /**
     * @param int $team_id
     */
    public function setTeamId(int $team_id): void
    {
        $this->team_id = $team_id;
    }

    /**
     * @return int
     */
    public function getGoalsScored(): int
    {
        return $this->goalsScored;
    }

    /**
     * @param int $goalsScored
     */
    public function setGoalsScored(int $goalsScored): void
    {
        $this->goalsScored = $goalsScored;
    }

    /**
     * @return int
     */
    public function getGoalsAgainst(): int
    {
        return $this->goalsAgainst;
    }

    /**
     * @param int $goalsAgainst
     */
    public function setGoalsAgainst(int $goalsAgainst): void
    {
        $this->goalsAgainst = $goalsAgainst;
    }

    /**
     * @return int
     */
    public function getLastGoalsScored(): int
    {
        return $this->lastGoalsScored;
    }

    /**
     * @param int $lastGoalsScored
     */
    public function setLastGoalsScored(int $lastGoalsScored): void
    {
        $this->lastGoalsScored = $lastGoalsScored;
    }

    /**
     * @return int
     */
    public function getLastGoalsAgainst(): int
    {
        return $this->lastGoalsAgainst;
    }

    /**
     * @param int $lastGoalsAgainst
     */
    public function setLastGoalsAgainst(int $lastGoalsAgainst): void
    {
        $this->lastGoalsAgainst = $lastGoalsAgainst;
    }

    public function addGoalsScored(int $goals)
    {
        $this->goalsScored += $goals;
    }

    public function addGoalsAgainst(int $goals)
    {
        $this->goalsAgainst += $goals;
    }

    public function addLastGoalsScored(int $goals)
    {
        $this->lastGoalsScored += $goals;
    }

    public function addLastGoalsAgainst(int $goals)
    {
        $this->lastGoalsAgainst += $goals;
    }
}