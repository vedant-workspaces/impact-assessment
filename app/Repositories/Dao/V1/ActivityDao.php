<?php

namespace App\Repositories\Dao\V1;

class ActivityDao
{
    public int $ngoId = 0;

    public int $programId = 0;

    public string $name = '';

    public string $description = '';

    public int $assignedBy = 0;

    public float $totalBudget = 0.0;

    public float $budgetUsed = 0.0;

    public int $totalBeneficiaries = 0;

    public int $beneficiariesReached = 0;

    public int $isMediaUploads = 0;

    public string $startDate = '';

    public string $endDate = '';

    public string $createdAt = '';

    public string $updatedAt = '';

    public function toArray()
    {
        $collection = [];
        if (isset($this->ngoId) && intval($this->ngoId) > 0) {
            $collection['ngo_id'] = $this->ngoId;
        }
        if (isset($this->programId) && intval($this->programId) > 0) {
            $collection['program_id'] = $this->programId;
        }
        if (isset($this->name) && $this->name !== '') {
            $collection['name'] = $this->name;
        }
        if (isset($this->description) && $this->description !== '') {
            $collection['description'] = $this->description;
        }
        if (isset($this->assignedBy) && intval($this->assignedBy) > 0) {
            $collection['assigned_by'] = $this->assignedBy;
        }
        if (isset($this->totalBudget)) {
            $collection['total_budget'] = $this->totalBudget;
        }
        if (isset($this->budgetUsed)) {
            $collection['budget_used'] = $this->budgetUsed;
        }
        if (isset($this->totalBeneficiaries)) {
            $collection['total_beneficiaries'] = $this->totalBeneficiaries;
        }
        if (isset($this->beneficiariesReached)) {
            $collection['beneficiaries_reached'] = $this->beneficiariesReached;
        }
        if (isset($this->isMediaUploads)) {
            $collection['is_media_uploads'] = $this->isMediaUploads;
        }
        if (isset($this->startDate) && $this->startDate !== '') {
            $collection['start_date'] = $this->startDate;
        }
        if (isset($this->endDate) && $this->endDate !== '') {
            $collection['end_date'] = $this->endDate;
        }
        if (isset($this->createdAt) && $this->createdAt !== '') {
            $collection['created_at'] = $this->createdAt;
        }
        if (isset($this->updatedAt) && $this->updatedAt !== '') {
            $collection['updated_at'] = $this->updatedAt;
        }

        return $collection;
    }

    public function setNgoId($ngoId)
    {
        $this->ngoId = $ngoId;

        return $this;
    }

    public function setProgramId($programId)
    {
        $this->programId = $programId;

        return $this;
    }

    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    public function setAssignedBy($assignedBy)
    {
        $this->assignedBy = $assignedBy;

        return $this;
    }

    public function setTotalBudget($totalBudget)
    {
        $this->totalBudget = $totalBudget;

        return $this;
    }

    public function setTotalBeneficiaries($total)
    {
        $this->totalBeneficiaries = $total;

        return $this;
    }

    public function setIsMediaUploads($v)
    {
        $this->isMediaUploads = $v;

        return $this;
    }

    public function setStartDate($d)
    {
        $this->startDate = $d;

        return $this;
    }

    public function setEndDate($d)
    {
        $this->endDate = $d;

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
