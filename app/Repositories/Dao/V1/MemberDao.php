<?php

namespace App\Repositories\Dao\V1;

class MemberDao
{
    public int $userId = 0;

    public int $ngoId = 0;

    public string $fullName = '';

    public string $gender = '';

    public string $designation = '';

    public string $department = '';

    public string $contactNumber = '';

    public string $officialEmail = '';

    public int $roleType = 0;

    public int $accessLevel = 0;

    public int $status = 0;

    public string $assignedBy = '';

    public string $createdAt = '';

    public string $updatedAt = '';

    public function toArray()
    {
        $collection = [];

        if (isset($this->userId)) {
            $collection['user_id'] = $this->userId;
        }
        if (isset($this->ngoId)) {
            $collection['ngo_id'] = $this->ngoId;
        }
        if (isset($this->fullName)) {
            $collection['full_name'] = $this->fullName;
        }
        if (isset($this->gender)) {
            $collection['gender'] = $this->gender;
        }
        if (isset($this->designation)) {
            $collection['designation'] = $this->designation;
        }
        if (isset($this->department)) {
            $collection['department'] = $this->department;
        }
        if (isset($this->contactNumber)) {
            $collection['contact_number'] = $this->contactNumber;
        }
        if (isset($this->officialEmail)) {
            $collection['official_email'] = $this->officialEmail;
        }
        if (isset($this->roleType)) {
            $collection['role_type'] = $this->roleType;
        }
        if (isset($this->accessLevel)) {
            $collection['access_level'] = $this->accessLevel;
        }
        if (isset($this->status)) {
            $collection['status'] = $this->status;
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

    /**
     * Get the value of userId
     */ 
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Set the value of userId
     *
     * @return  self
     */ 
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    public function getNgoId()
    {
        return $this->ngoId;
    }

    public function setNgoId($ngoId)
    {
        $this->ngoId = $ngoId;

        return $this;
    }

    /**
     * Get the value of fullName
     */ 
    public function getFullName()
    {
        return $this->fullName;
    }

    /**
     * Set the value of fullName
     *
     * @return  self
     */ 
    public function setFullName($fullName)
    {
        $this->fullName = $fullName;

        return $this;
    }

    /**
     * Get the value of gender
     */ 
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Set the value of gender
     *
     * @return  self
     */ 
    public function setGender($gender)
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * Get the value of designation
     */ 
    public function getDesignation()
    {
        return $this->designation;
    }

    /**
     * Set the value of designation
     *
     * @return  self
     */ 
    public function setDesignation($designation)
    {
        $this->designation = $designation;

        return $this;
    }

    /**
     * Get the value of department
     */ 
    public function getDepartment()
    {
        return $this->department;
    }

    /**
     * Set the value of department
     *
     * @return  self
     */ 
    public function setDepartment($department)
    {
        $this->department = $department;

        return $this;
    }

    /**
     * Get the value of contactNumber
     */ 
    public function getContactNumber()
    {
        return $this->contactNumber;
    }

    /**
     * Set the value of contactNumber
     *
     * @return  self
     */ 
    public function setContactNumber($contactNumber)
    {
        $this->contactNumber = $contactNumber;

        return $this;
    }

    /**
     * Get the value of officialEmail
     */ 
    public function getOfficialEmail()
    {
        return $this->officialEmail;
    }

    /**
     * Set the value of officialEmail
     *
     * @return  self
     */ 
    public function setOfficialEmail($officialEmail)
    {
        $this->officialEmail = $officialEmail;

        return $this;
    }

    /**
     * Get the value of roleType
     */ 
    public function getRoleType()
    {
        return $this->roleType;
    }

    /**
     * Set the value of roleType
     *
     * @return  self
     */ 
    public function setRoleType($roleType)
    {
        $this->roleType = $roleType;

        return $this;
    }

    /**
     * Get the value of accessLevel
     */ 
    public function getAccessLevel()
    {
        return $this->accessLevel;
    }

    /**
     * Set the value of accessLevel
     *
     * @return  self
     */ 
    public function setAccessLevel($accessLevel)
    {
        $this->accessLevel = $accessLevel;

        return $this;
    }

    /**
     * Get the value of status
     */ 
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set the value of status
     *
     * @return  self
     */ 
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get the value of assignedBy
     */ 
    public function getAssignedBy()
    {
        return $this->assignedBy;
    }

    /**
     * Set the value of assignedBy
     *
     * @return  self
     */ 
    public function setAssignedBy($assignedBy)
    {
        $this->assignedBy = $assignedBy;

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
