<?php

namespace App\Repositories\Dao\V1;

class ActivityMilestoneDao
{
    public int $activityId = 0;

    public int $ngoId = 0;

    public string $name = '';

    public ?string $startDate = null;

    public ?string $endDate = null;

    public int $milestoneStatus = 0;

    public ?string $createdAt = null;

    public ?string $updatedAt = null;

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
        if (isset($this->milestoneStatus)) {
            $collection['milestone_status'] = $this->milestoneStatus;
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
        if ($d === null) {
            $this->startDate = null;
        } elseif ($d instanceof \DateTimeInterface) {
            $this->startDate = $d->format('Y-m-d');
        } else {
            $this->startDate = (string) $d;
        }

        return $this;
    }

    public function setEndDate($d)
    {
        if ($d === null) {
            $this->endDate = null;
        } elseif ($d instanceof \DateTimeInterface) {
            $this->endDate = $d->format('Y-m-d');
        } else {
            $this->endDate = (string) $d;
        }

        return $this;
    }

    public function setMilestoneStatus($s)
    {
        $this->milestoneStatus = intval($s);

        return $this;
    }

    public function setCreatedAt($d)
    {
        if ($d === null) {
            $this->createdAt = null;
        } elseif ($d instanceof \DateTimeInterface) {
            $this->createdAt = $d->format('Y-m-d H:i:s');
        } else {
            $this->createdAt = (string) $d;
        }

        return $this;
    }

    public function setUpdatedAt($d)
    {
        if ($d === null) {
            $this->updatedAt = null;
        } elseif ($d instanceof \DateTimeInterface) {
            $this->updatedAt = $d->format('Y-m-d H:i:s');
        } else {
            $this->updatedAt = (string) $d;
        }

        return $this;
    }
}
