<?php

namespace App\Repositories\Dao\V1;

class ActivityMilestoneDao
{
    public int $activityId = 0;

    public int $ngoId = 0;

    public string $name = '';

    public string $startDate = '';

    public string $endDate = '';

    public string $createdAt = '';

    public string $updatedAt = '';

    public function toArray()
    {
        $collection = [];
        if (isset($this->activityId)) {
            $collection['activity_id'] = $this->activityId;
        }
        if (isset($this->ngoId) && intval($this->ngoId) > 0) {
            $collection['ngo_id'] = $this->ngoId;
        }
        if (isset($this->name) && $this->name !== '') {
            $collection['name'] = $this->name;
        }
        if (isset($this->startDate) && $this->startDate !== '') {
            $collection['start_date'] = $this->startDate;
        }
        if (isset($this->endDate) && $this->endDate !== '') {
            $collection['end_date'] = $this->endDate;
        }
        if (isset($this->createdAt)) {
            $collection['created_at'] = $this->createdAt;
        }
        if (isset($this->updatedAt)) {
            $collection['updated_at'] = $this->updatedAt;
        }

        return $collection;
    }

    public function setActivityId($id)
    {
        $this->activityId = $id;

        return $this;
    }

    public function setNgoId($id)
    {
        $this->ngoId = $id;

        return $this;
    }

    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    public function setStartDate($d)
    {
        $this->startDate = $d;

        return $this;
    }

    public function setEndDate($d)
    {
        $this->endDate = $d;

        return $this;
    }

    public function setCreatedAt($d)
    {
        $this->createdAt = $d;

        return $this;
    }

    public function setUpdatedAt($d)
    {
        $this->updatedAt = $d;

        return $this;
    }
}
