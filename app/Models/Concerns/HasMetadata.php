<?php

/*|=============================================================================|
  | HasMetadata.php
  | Ian Kollipara <ikollipara2@huskers.unl.edu>
  |-----------------------------------------------------------------------------|
  | This file defines the `HasMetadata` Concern for models that enables fluid
  | integration of Metadata for models
  |=============================================================================| */

namespace App\Models\Concerns;

use App\ValueObjects\Metadata;

/**
 * |=============================================================================|
 * | HasMetadata
 * |-----------------------------------------------------------------------------|
 * | This define a trait that adds metadata to a model and enables rich access of it.
 * | To make use of, make sure the model has a `metadata` jsonb column.
 * |-----------------------------------------------------------------------------|
 *
 * @property Metadata $metadata;
 * |=============================================================================| */
trait HasMetadata
{
    public function getMetadataAttribute()
    {
        return new Metadata(json_decode($this->attributes['metadata'], true));
    }

    public function setMetadataAttribute(Metadata $metadata)
    {
        $this->attributes['metadata'] = $metadata->__toString();
    }

    public static function bootHasMetadata()
    {
        static::saving(function ($model) {
            $model->attributes['metadata'] = $model->metadata->__toString();
        });
    }
}
