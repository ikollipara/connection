<?php

/*|=============================================================================|
  | IsSearchable.php
  | Ian Kollipara <ikollipara2@huskers.unl.edu>
  |-----------------------------------------------------------------------------|
  | This file contains the Searchable interface. This interface is responsible for
  | providing a common interface for the search service to use.
  |=============================================================================| */

namespace App\Contracts;

/**
 * |=============================================================================|
 * | IsSearchable
 * |-----------------------------------------------------------------------------|
 * |
 * |=============================================================================|
 * @template T of \Illuminate\Database\Eloquent\Model
 *
 * */
interface IsSearchable
{
    public static function normalizeSearchConstraints(
        array $constraints
    ): array;
    public function scopeWithSearchConstraints($query, array $constraints);
}
