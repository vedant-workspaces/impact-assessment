<?php

namespace App\Services\Bo\V1;

class RegisterNgoBo
{
    public ?string $organisationEmail = null;

    public ?string $userName = null;

    public ?string $password = null;

    public ?string $organisationWebsite = null;

    public ?string $organisationName = null;

    public ?string $contactPersonName = null;

    public ?string $contactPersonDesignation = null;

    public ?string $contactPersonNumber = null;

    public ?string $organisationAddress = null;

    public ?string $organisationCity = null;

    public ?string $organisationState = null;

    public ?string $organisationPincode = null;

    public ?array $primarySector = [];

    public ?array $sdgs = [];

    public ?string $purpose = null;

    /**
     * Get the value of organisationEmail
     */ 
    public function getOrganisationEmail()
    {
        return $this->organisationEmail;
    }

    /**
     * Set the value of organisationEmail
     *
     * @return  self
     */ 
    public function setOrganisationEmail($organisationEmail)
    {
        $this->organisationEmail = $organisationEmail;

        return $this;
    }

    /**
     * Get the value of userName
     */ 
    public function getUserName()
    {
        return $this->userName;
    }

    /**
     * Set the value of userName
     *
     * @return  self
     */ 
    public function setUserName($userName)
    {
        $this->userName = $userName;

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
     * Get the value of primarySector
     */ 
    public function getPrimarySector()
    {
        return $this->primarySector;
    }

    /**
     * Set the value of primarySector
     *
     * @return  self
     */ 
    public function setPrimarySector($primarySector)
    {
        $this->primarySector = $primarySector;

        return $this;
    }

    /**
     * Get the value of sdgs
     */ 
    public function getSdgs()
    {
        return $this->sdgs;
    }

    /**
     * Set the value of sdgs
     *
     * @return  self
     */ 
    public function setSdgs($sdgs)
    {
        $this->sdgs = $sdgs;

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
}