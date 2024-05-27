<?php

/*|=============================================================================|
  | LazyLoading.php
  | Ian Kollipara <ikollipara2@huskers.unl.edu>
  |-----------------------------------------------------------------------------|
  | This trait abstracts Livewire lazy loading functionality.
  |=============================================================================| */

namespace App\Http\Livewire\Concerns;

/**
 * |=============================================================================|
 * | LazyLoading
 * |-----------------------------------------------------------------------------|
 * | This trait abstracts Livewire lazy loading functionality.
 * |=============================================================================| */
trait LazyLoading
{
    protected function lazyLoadingProperties(): array
    {
        return $this->lazy ?? [];
    }

    public function load(string $lazy_property): void
    {
        $this->{"ready_to_load_" . $lazy_property} = true;
    }

    public function mountLazyLoading(): void
    {
        foreach ($this->lazyLoadingProperties() as $property) {
            $this->{"ready_to_load_" . $property} = false;
        }
    }
}
