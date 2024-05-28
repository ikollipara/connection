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
    protected function getRichTextAttributes(): array
    {
        return $this->rich_text_attributes ?? [];
    }

    public static function bootHasRichText()
    {
        static::retrieved(function ($model) {
            foreach ($model->getRichTextAttributes() as $attribute) {
                $model->{"get" .
                    ucfirst($attribute) .
                    "TextAttribute"} = function () use ($model, $attribute) {
                    return BodyExtractor::extract(
                        is_string($model->{$attribute})
                            ? json_decode($model->{$attribute}, true)
                            : $model->{$attribute},
                    );
                };
            }
        });
        static::saving(function ($model) {
            foreach ($model->getRichTextAttributes() as $attribute) {
                unset($model->{"get" . ucfirst($attribute) . "TextAttribute"});
            }
        });

        static::saved(function ($model) {
            foreach ($model->getRichTextAttributes() as $attribute) {
                $model->{"get" .
                    ucfirst($attribute) .
                    "TextAttribute"} = function () use ($model, $attribute) {
                    return BodyExtractor::extract(
                        is_string($model->{$attribute})
                            ? json_decode($model->{$attribute}, true)
                            : $model->{$attribute},
                    );
                };
            }
        });
    }
}
