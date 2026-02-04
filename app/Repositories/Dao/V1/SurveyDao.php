<?php

namespace App\Repositories\Dao\V1;

class SurveyDao
{
    public string $title = '';

    public string $startDate = '';

    public string $endDate = '';

    public int $programId = 0;

    public int $assignedBy = 0;

    public string $createdAt = '';

    public string $updatedAt = '';

    public function toArray()
    {
        $collection = [];
        if (isset($this->title)) {
            $collection['title'] = $this->title;
        }
        if (isset($this->startDate)) {
            $collection['start_date'] = $this->startDate;
        }
        if (isset($this->endDate)) {
            $collection['end_date'] = $this->endDate;
        }
        if (isset($this->programId)) {
            $collection['program_id'] = $this->programId;
        }
        if (isset($this->assignedBy)) {
            $collection['assigned_by'] = $this->assignedBy;
        }
        if (isset($this->createdAt)) {
            $collection['created_at'] = $this->createdAt;
        }
        if (isset($this->updatedAt)) {
            $collection['updated_at'] = $this->updatedAt;
        }

        return $collection;
    }

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

    public function getProgramId()
    {
        return $this->programId;
    }

    public function setProgramId($programId)
    {
        $this->programId = $programId;

        return $this;
    }

    public function getAssignedBy()
    {
        return $this->assignedBy;
    }

    public function setAssignedBy($assignedBy)
    {
        $this->assignedBy = $assignedBy;

        return $this;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
