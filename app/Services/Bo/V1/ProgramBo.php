<?php

namespace App\Services\Bo\V1;

class ProgramBo
{
    public string $title = '';

    public string $description = '';

    public string $startDate = '';

    public string $endDate = '';

    public int $leaderId = 0;

    public array $memberIds = [];

    /**
     * Get the value of title
     */ 
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set the value of title
     *
     * @return  self
     */ 
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get the value of description
     */ 
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set the value of description
     *
     * @return  self
     */ 
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get the value of startDate
     */ 
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * Set the value of startDate
     *
     * @return  self
     */ 
    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;

        return $this;
    }

    /**
     * Get the value of endDate
     */ 
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * Set the value of endDate
     *
     * @return  self
     */ 
    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;

        return $this;
    }

    /**
     * Get the value of leaderId
     */ 
    public function getLeaderId()
    {
        return $this->leaderId;
    }

    /**
     * Set the value of leaderId
     *
     * @return  self
     */ 
    public function setLeaderId($leaderId)
    {
        $this->leaderId = $leaderId;

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
}