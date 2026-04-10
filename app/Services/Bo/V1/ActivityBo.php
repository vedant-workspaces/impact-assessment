<?php

namespace App\Services\Bo\V1;

class ActivityBo
{
    public string $name = '';

    public string $description = '';

    public string $startDate = '';

    public string $endDate = '';

    public int $programId = 0;

    public array $leaderIds = [];

    public array $memberIds = [];

    public array $milestones = [];

    public float $totalBudget = 0.0;

    public int $totalBeneficiaries = 0;

    public int $isMediaUploads = 0;

    public function getName()
    {
        return $this->name;
    }

    public function setName($v)
    {
        $this->name = $v;

        return $this;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($v)
    {
        $this->description = $v;

        return $this;
    }

    public function getStartDate()
    {
        return $this->startDate;
    }

    public function setStartDate($v)
    {
        $this->startDate = $v;

        return $this;
    }

    public function getEndDate()
    {
        return $this->endDate;
    }

    public function setEndDate($v)
    {
        $this->endDate = $v;

        return $this;
    }

    public function getProgramId()
    {
        return $this->programId;
    }

    public function setProgramId($v)
    {
        $this->programId = $v;

        return $this;
    }

    public function getLeaderIds()
    {
        return $this->leaderIds;
    }

    public function setLeaderIds($v)
    {
        $this->leaderIds = $v;

        return $this;
    }

    public function getMemberIds()
    {
        return $this->memberIds;
    }

    public function setMemberIds($v)
    {
        $this->memberIds = $v;

        return $this;
    }

    public function getMilestones()
    {
        return $this->milestones;
    }

    public function setMilestones($v)
    {
        $this->milestones = $v;

        return $this;
    }

    public function getTotalBudget()
    {
        return $this->totalBudget;
    }

    public function setTotalBudget($v)
    {
        $this->totalBudget = $v;

        return $this;
    }

    public function getTotalBeneficiaries()
    {
        return $this->totalBeneficiaries;
    }

    public function setTotalBeneficiaries($v)
    {
        $this->totalBeneficiaries = $v;

        return $this;
    }

    public function getIsMediaUploads()
    {
        return $this->isMediaUploads;
    }

    public function setIsMediaUploads($v)
    {
        $this->isMediaUploads = $v;

        return $this;
    }
}
