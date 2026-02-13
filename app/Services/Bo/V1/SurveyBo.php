<?php

namespace App\Services\Bo\V1;

class SurveyBo
{
    public string $title = '';

    public string $startDate = '';

    public string $endDate = '';

    public array $leaderIds = [];

    public int $programId = 0;

    public array $memberIds = [];

    public string $description = '';

    /**
     * Questions array expected in the format provided by the client
     */
    public array $questions = [];

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    public function getStartDate()
    {
        return $this->startDate;
    }

    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate()
    {
        return $this->endDate;
    }

    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function getLeaderIds()
    {
        return $this->leaderIds;
    }

    public function setLeaderIds($leaderIds)
    {
        $this->leaderIds = $leaderIds;

        return $this;
    }

    public function getProgramId()
    {
        return $this->programId;
    }

    public function setProgramId($programId)
    {
        $this->programId = $programId;

        return $this;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    public function getMemberIds()
    {
        return $this->memberIds;
    }

    public function setMemberIds($memberIds)
    {
        $this->memberIds = $memberIds;

        return $this;
    }

    public function getQuestions()
    {
        return $this->questions;
    }

    public function setQuestions($questions)
    {
        $this->questions = $questions;

        return $this;
    }
}
