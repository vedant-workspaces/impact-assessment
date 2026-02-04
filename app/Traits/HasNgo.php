<?php

namespace App\Traits;

trait HasNgo
{
    /**
     * Boot the HasNgo trait for a model.
     */
    protected static function bootHasNgo()
    {
        static::creating(function ($model) {
            // Only set ngo_id if the model has the attribute and it's not already set
            if (property_exists($model, 'attributes') && array_key_exists('ngo_id', $model->getAttributes()) === false) {
                // If ngo_id wasn't present in attributes, attempt to set from container
                $ngoId = app('current_ngo_id') ?? 0;
                $model->ngo_id = $ngoId;
            }

            // If attribute exists but is null/empty, also set
            if (isset($model->ngo_id) === false || $model->ngo_id === null) {
                $model->ngo_id = app('current_ngo_id') ?? 0;
            }
        });
    }
}
