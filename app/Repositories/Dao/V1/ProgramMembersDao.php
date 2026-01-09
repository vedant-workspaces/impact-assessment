<?php

namespace App\Repositories\Dao\V1;

class ProgramMembersDao
{
    public int $programId = 0;

    public int $memberIds = 0;

    public int $role = 0;

    public string $createdAt = '';

    public string $updatedAt = '';

    public function toArray()
    {
        $collection = [];
        if (isset($this->programId)) {
            $collection['program_id'] = $this->programId;
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

    /**
     * Get the value of programId
     */ 
    public function getProgramId()
    {
        return $this->programId;
    }

    /**
     * Set the value of programId
     *
     * @return  self
     */ 
    public function setProgramId($programId)
    {
        $this->programId = $programId;

        return $this;
    }

    /**
     * Get the value of memberIds
     */ 
    public function getMemberIds()
    {
        return $this->memberIds;
    }

    /**
     * Set the value of memberIds
     *
     * @return  self
     */ 
    public function setMemberIds($memberIds)
    {
        $this->memberIds = $memberIds;

        return $this;
    }

    /**
     * Get the value of role
     */ 
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Set the value of role
     *
     * @return  self
     */ 
    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Get the value of createdAt
     */ 
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set the value of createdAt
     *
     * @return  self
     */ 
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get the value of updatedAt
     */ 
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set the value of updatedAt
     *
     * @return  self
     */ 
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}