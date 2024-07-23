<?php

/*|=============================================================================|
  | HasRichText.php
  | Ian Kollipara <ikollipara2@huskers.unl.edu>
  |-----------------------------------------------------------------------------|
  | This file contains the HasRichText trait, which is used to add rich text
  | functionality to models.
  |=============================================================================| */

namespace App\Models\Concerns;

use App\Services\BodyExtractor;

/**
 * |=============================================================================|
 * | HasRichText
 * |-----------------------------------------------------------------------------|
 * | This trait is used to add rich text functionality to models.
 * |-----------------------------------------------------------------------------|
 * @property array<string> $rich_text_attributes
 * |=============================================================================| */
trait HasRichText
{
    public function asPlainText(string $attribute): string
    {
        return BodyExtractor::extract(
            is_string($this->{$attribute}) ? json_decode($this->{$attribute}, true) : $this->{$attribute},
        );
    }
}
