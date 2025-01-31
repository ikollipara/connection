<?php

declare(strict_types=1);

/*|=============================================================================|
  | HasMetadata.php
  | Ian Kollipara <ikollipara2@huskers.unl.edu>
  |-----------------------------------------------------------------------------|
  | This file defines the `HasMetadata` Concern for models that enables fluid
  | integration of Metadata for models
  |=============================================================================| */

namespace App\Models\Concerns;

use App\ValueObjects\Metadata;
use Illuminate\Database\Eloquent\Casts\Attribute;

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
    public function metadata(): Attribute
    {
        return Attribute::make(
            get: fn(string $value) => new Metadata(json_decode($value, associative: true)),
            set: fn(Metadata $metadata) => $metadata->__toString(),
        );
    }

    public static function bootHasMetadata()
    {
        static::saving(function ($model) {
            $model->attributes['metadata'] = $model->metadata->__toString();
        });
    }
}
