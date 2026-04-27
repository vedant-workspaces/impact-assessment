<?php

namespace App\Repositories\Dao\V1;

class ActivityMembersDao
{
    public int $activityId = 0;

    public int $memberIds = 0;

    public int $role = 0;

    public ?string $createdAt = null;

    public ?string $updatedAt = null;

    public function toArray()
    {
        $collection = [];
        if (isset($this->activityId)) {
            $collection['activity_id'] = $this->activityId;
        }
        if (isset($this->memberIds)) {
            $collection['member_id'] = $this->memberIds;
        }
        if (isset($this->role)) {
            $collection['role'] = $this->role;
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

    public function setMemberIds($memberId)
    {
        $this->memberIds = $memberId;

        return $this;
    }

    public function setRole($role)
    {
        $this->role = $role;

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
