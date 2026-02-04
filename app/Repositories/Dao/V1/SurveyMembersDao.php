<?php

namespace App\Repositories\Dao\V1;

class SurveyMembersDao
{
    public int $surveyId = 0;

    public int $memberIds = 0;

    public int $role = 0;

    public string $createdAt = '';

    public string $updatedAt = '';

    public function toArray()
    {
        $collection = [];
        if (isset($this->surveyId)) {
            $collection['survey_id'] = $this->surveyId;
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

    public function getSurveyId()
    {
        return $this->surveyId;
    }

    public function setSurveyId($surveyId)
    {
        $this->surveyId = $surveyId;

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

    public function getRole()
    {
        return $this->role;
    }

    public function setRole($role)
    {
        $this->role = $role;

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
