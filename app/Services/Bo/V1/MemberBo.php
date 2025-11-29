<?php

namespace App\Services\Bo\V1;

class MemberBo
{
    public string $fullName = '';

    public string $gender = '';

    public string $designation = '';

    public string $department = '';

    public string $contactNumber = '';

    public string $officialEmail = '';

    public string $username = '';

    public string $password = '';

    public int $roleType = 0;

    public int $accessLevel = 0;

    public int $status = 0;

    public string $assignedBy = '';

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
     * Get the value of username
     */ 
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set the value of username
     *
     * @return  self
     */ 
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get the value of password
     */ 
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set the value of password
     *
     * @return  self
     */ 
    public function setPassword($password)
    {
        $this->password = $password;

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
}