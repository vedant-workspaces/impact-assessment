<?php

namespace App\Repositories\Dao\V1;

class RegisterNgoDao
{
    public int $userId = 0;

    public ?string $organisationWebsite = null;

    public string $organisationName = '';

    public string $contactPersonName = '';

    public string $contactPersonDesignation = '';

    public string $contactPersonNumber = '';

    public string $organisationAddress = '';

    public string $organisationCity = '';

    public string $organisationState = '';

    public string $organisationPincode = '';

    public string $primarySectorIds = '';

    public string $sdgIds = '';

    public ?string $purpose = null;

    public string $createdAt = '';

    public string $updatedAt = '';
    
    public function toArray()
    {
        $collection = [];

        if (isset($this->userId)) {
            $collection['user_id'] = $this->userId;
        }
        if (isset($this->organisationWebsite)) {
            $collection['organisation_website'] = $this->organisationWebsite;
        }
        if (isset($this->organisationName)) {
            $collection['organisation_name'] = $this->organisationName;
        }
        if (isset($this->contactPersonName)) {
            $collection['contact_person_name'] = $this->contactPersonName;
        }
        if (isset($this->contactPersonDesignation)) {
            $collection['contact_person_designation'] = $this->contactPersonDesignation;
        }
        if (isset($this->contactPersonNumber)) {
            $collection['contact_person_number'] = $this->contactPersonNumber;
        }
        if (isset($this->organisationAddress)) {
            $collection['organisation_address'] = $this->organisationAddress;
        }
        if (isset($this->organisationCity)) {
            $collection['organisation_city'] = $this->organisationCity;
        }
        if (isset($this->organisationState)) {
            $collection['organisation_state'] = $this->organisationState;
        }
        if (isset($this->organisationPincode)) {
            $collection['organisation_pincode'] = $this->organisationPincode;
        }
        if (isset($this->primarySectorIds)) {
            $collection['primary_sector_ids'] = $this->primarySectorIds;
        }
        if (isset($this->sdgIds)) {
            $collection['sdg_ids'] = $this->sdgIds;
        }
        if (isset($this->purpose)) {
            $collection['purpose'] = $this->purpose;
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

    /**
     * Get the value of organisationWebsite
     */ 
    public function getOrganisationWebsite()
    {
        return $this->organisationWebsite;
    }

    /**
     * Set the value of organisationWebsite
     *
     * @return  self
     */ 
    public function setOrganisationWebsite($organisationWebsite)
    {
        $this->organisationWebsite = $organisationWebsite;

        return $this;
    }

    /**
     * Get the value of organisationName
     */ 
    public function getOrganisationName()
    {
        return $this->organisationName;
    }

    /**
     * Set the value of organisationName
     *
     * @return  self
     */ 
    public function setOrganisationName($organisationName)
    {
        $this->organisationName = $organisationName;

        return $this;
    }

    /**
     * Get the value of contactPersonName
     */ 
    public function getContactPersonName()
    {
        return $this->contactPersonName;
    }

    /**
     * Set the value of contactPersonName
     *
     * @return  self
     */ 
    public function setContactPersonName($contactPersonName)
    {
        $this->contactPersonName = $contactPersonName;

        return $this;
    }

    /**
     * Get the value of contactPersonDesignation
     */ 
    public function getContactPersonDesignation()
    {
        return $this->contactPersonDesignation;
    }

    /**
     * Set the value of contactPersonDesignation
     *
     * @return  self
     */ 
    public function setContactPersonDesignation($contactPersonDesignation)
    {
        $this->contactPersonDesignation = $contactPersonDesignation;

        return $this;
    }

    /**
     * Get the value of contactPersonNumber
     */ 
    public function getContactPersonNumber()
    {
        return $this->contactPersonNumber;
    }

    /**
     * Set the value of contactPersonNumber
     *
     * @return  self
     */ 
    public function setContactPersonNumber($contactPersonNumber)
    {
        $this->contactPersonNumber = $contactPersonNumber;

        return $this;
    }

    /**
     * Get the value of organisationAddress
     */ 
    public function getOrganisationAddress()
    {
        return $this->organisationAddress;
    }

    /**
     * Set the value of organisationAddress
     *
     * @return  self
     */ 
    public function setOrganisationAddress($organisationAddress)
    {
        $this->organisationAddress = $organisationAddress;

        return $this;
    }

    /**
     * Get the value of organisationCity
     */ 
    public function getOrganisationCity()
    {
        return $this->organisationCity;
    }

    /**
     * Set the value of organisationCity
     *
     * @return  self
     */ 
    public function setOrganisationCity($organisationCity)
    {
        $this->organisationCity = $organisationCity;

        return $this;
    }

    /**
     * Get the value of organisationState
     */ 
    public function getOrganisationState()
    {
        return $this->organisationState;
    }

    /**
     * Set the value of organisationState
     *
     * @return  self
     */ 
    public function setOrganisationState($organisationState)
    {
        $this->organisationState = $organisationState;

        return $this;
    }

    /**
     * Get the value of organisationPincode
     */ 
    public function getOrganisationPincode()
    {
        return $this->organisationPincode;
    }

    /**
     * Set the value of organisationPincode
     *
     * @return  self
     */ 
    public function setOrganisationPincode($organisationPincode)
    {
        $this->organisationPincode = $organisationPincode;

        return $this;
    }

    /**
     * Get the value of primarySectorIds
     */ 
    public function getPrimarySectorIds()
    {
        return $this->primarySectorIds;
    }

    /**
     * Set the value of primarySectorIds
     *
     * @return  self
     */ 
    public function setPrimarySectorIds($primarySectorIds)
    {
        $this->primarySectorIds = $primarySectorIds;

        return $this;
    }

    /**
     * Get the value of sdgIds
     */ 
    public function getSdgIds()
    {
        return $this->sdgIds;
    }

    /**
     * Set the value of sdgIds
     *
     * @return  self
     */ 
    public function setSdgIds($sdgIds)
    {
        $this->sdgIds = $sdgIds;

        return $this;
    }

    /**
     * Get the value of purpose
     */ 
    public function getPurpose()
    {
        return $this->purpose;
    }

    /**
     * Set the value of purpose
     *
     * @return  self
     */ 
    public function setPurpose($purpose)
    {
        $this->purpose = $purpose;

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