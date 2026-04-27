<?php

namespace App\Repositories\Dao\V1;

class ActivityDao
{
    public int $ngoId = 0;

    public int $programId = 0;

    public string $name = '';

    public ?string $description = null;

    public int $assignedBy = 0;

    public float $totalBudget = 0.0;

    public float $budgetUsed = 0.0;

    public int $totalBeneficiaries = 0;

    public int $beneficiariesReached = 0;

    public int $isMediaUploads = 0;

    public int $mediaStatus = 2;

    public ?string $mediaLink = null;

    public ?string $startDate = null;

    public ?string $endDate = null;

    public ?string $createdAt = null;

    public ?string $updatedAt = null;

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
        if (isset($this->mediaStatus)) {
            $collection['media_status'] = $this->mediaStatus;
        }
        if (isset($this->mediaLink) && $this->mediaLink !== '') {
            $collection['media_link'] = $this->mediaLink;
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
        $this->description = $description === null ? null : (string) $description;

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

    public function setMediaStatus($s)
    {
        $this->mediaStatus = $s;

        return $this;
    }

    public function setMediaLink($l)
    {
        $this->mediaLink = $l === null ? null : (string) $l;

        return $this;
    }

    public function setStartDate($d)
    {
        if ($d === null) {
            $this->startDate = null;
        } elseif ($d instanceof \DateTimeInterface) {
            $this->startDate = $d->format('Y-m-d');
        } else {
            $this->startDate = (string) $d;
        }

        return $this;
    }

    public function setEndDate($d)
    {
        if ($d === null) {
            $this->endDate = null;
        } elseif ($d instanceof \DateTimeInterface) {
            $this->endDate = $d->format('Y-m-d');
        } else {
            $this->endDate = (string) $d;
        }

        return $this;
    }

    public function setCreatedAt($d)
    {
        if ($d === null) {
            $this->createdAt = null;
        } elseif ($d instanceof \DateTimeInterface) {
            $this->createdAt = $d->format('Y-m-d H:i:s');
        } else {
            $this->createdAt = (string) $d;
        }

        return $this;
    }

    public function setUpdatedAt($d)
    {
        if ($d === null) {
            $this->updatedAt = null;
        } elseif ($d instanceof \DateTimeInterface) {
            $this->updatedAt = $d->format('Y-m-d H:i:s');
        } else {
            $this->updatedAt = (string) $d;
        }

        return $this;
    }
}
