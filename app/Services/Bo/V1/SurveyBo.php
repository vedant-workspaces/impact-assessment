<?php

namespace App\Services\Bo\V1;

class SurveyBo
{
    public string $title = '';

    public string $startDate = '';

    public string $endDate = '';

    public int $leaderId = 0;

    public int $programId = 0;

    public array $memberIds = [];

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

    public function getLeaderId()
    {
        return $this->leaderId;
    }

    public function setLeaderId($leaderId)
    {
        $this->leaderId = $leaderId;

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

    public function getMemberIds()
    {
        return $this->memberIds;
    }

    public function setMemberIds($memberIds)
    {
        $this->memberIds = $memberIds;

        return $this;
    }
}
