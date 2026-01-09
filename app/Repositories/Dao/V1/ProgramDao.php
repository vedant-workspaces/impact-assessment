<?php

namespace App\Repositories\Dao\V1;

class ProgramDao
{
    public string $title = '';

    public string $description = '';

    public string $startDate = '';

    public string $endDate = '';

    public int $assignedBy = 0;

    public string $createdAt = '';

    public string $updatedAt = '';

    public function toArray()
    {
        $collection = [];
        if (isset($this->title)) {
            $collection['title'] = $this->title;
        }
        if (isset($this->description)) {
            $collection['description'] = $this->description;
        }
        if (isset($this->startDate)) {
            $collection['start_date'] = $this->startDate;
        }
        if (isset($this->endDate)) {
            $collection['end_date'] = $this->endDate;
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