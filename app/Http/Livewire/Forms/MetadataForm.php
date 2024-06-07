<?php

/*|=============================================================================|
  | MetadataForm.php
  | Ian Kollipara <ikollipara2@huskers.unl.edu>
  |-----------------------------------------------------------------------------|
  | This file contains the MetadataForm class, which is a Livewire form object
  | that is used to handle the form for creating and updating metadata.
  |=============================================================================| */

namespace App\Http\Livewire\Forms;

use App\ValueObjects\Metadata;
use Livewire\Wireable;

class MetadataForm implements Wireable
{
    public array $grades = [];
    public array $standards = [];
    public array $practices = [];
    public array $languages = [];
    public string $category;
    public string $audience;

    public function __construct()
    {
        $this->grades = [];
        $this->standards = [];
        $this->practices = [];
        $this->languages = [];
        $this->category = "";
        $this->audience = "";
    }

    public function toLivewire()
    {
        return [
            "grades" => $this->grades,
            "standards" => $this->standards,
            "practices" => $this->practices,
            "languages" => $this->languages,
            "category" => $this->category,
            "audience" => $this->audience,
        ];
    }

    public static function fromLivewire($value)
    {
        $instance = new static();
        $instance->grades = $value["grades"];
        $instance->standards = $value["standards"];
        $instance->practices = $value["practices"];
        $instance->languages = $value["languages"];
        $instance->category = $value["category"];
        $instance->audience = $value["audience"];
        return $instance;
    }

    public function fill(Metadata $metadata): void
    {
        $this->grades = $metadata->grades->toArray();
        $this->standards = $metadata->standards->toArray();
        $this->practices = $metadata->practices->toArray();
        $this->languages = $metadata->languages->toArray();
        $this->category = $metadata->category->value;
        $this->audience = $metadata->audience->value;
    }

    public function toMetadata(): Metadata
    {
        return new Metadata([
            "grades" => $this->grades,
            "standards" => $this->standards,
            "practices" => $this->practices,
            "languages" => $this->languages,
            "category" => $this->category,
            "audience" => $this->audience,
        ]);
    }
}
