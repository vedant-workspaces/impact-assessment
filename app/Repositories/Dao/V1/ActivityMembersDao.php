<?php

namespace App\Repositories\Dao\V1;

class ActivityMembersDao
{
    public int $activityId = 0;

    public int $memberIds = 0;

    public int $role = 0;

    public string $createdAt = '';

    public string $updatedAt = '';

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
        $this->createdAt = $d;

        return $this;
    }

    public function setUpdatedAt($d)
    {
        $this->updatedAt = $d;

        return $this;
    }
}
