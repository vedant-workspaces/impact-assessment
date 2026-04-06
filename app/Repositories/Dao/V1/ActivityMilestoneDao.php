<?php

namespace App\Repositories\Dao\V1;

class ActivityMilestoneDao
{
    public int $activityId = 0;

    public int $ngoId = 0;

    public string $name = '';

    public int $totalDuration = 0;

    public int $durationTaken = 0;

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
        if (isset($this->totalDuration)) {
            $collection['total_duration'] = $this->totalDuration;
        }
        if (isset($this->durationTaken)) {
            $collection['duration_taken'] = $this->durationTaken;
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

    public function setTotalDuration($d)
    {
        $this->totalDuration = $d;

        return $this;
    }

    public function setDurationTaken($d)
    {
        $this->durationTaken = $d;

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
