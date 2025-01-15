<?php

namespace App\Models\Concerns;

use Str;

trait Sluggable
{
    protected function getSluggableColumn(): string
    {
        return $this->sluggableColumn ?? 'title';
    }

    public function getRouteKey()
    {
        return Str::slug($this->{$this->getSluggableColumn()}).'--'.$this->getAttribute($this->getRouteKeyName());
    }

    public function resolveRouteBinding($value, $field = null)
    {
        $id = last(explode('--', $value));

        return parent::resolveRouteBinding($id, $field);
    }

    public function resolveSoftDeletableRouteBinding($value, $field = null)
    {
        $id = last(explode('--', $value));

        return parent::resolveSoftDeletableRouteBinding($id, $field);
    }
}
