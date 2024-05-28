<?php

namespace App\Traits\Livewire;

use App\Enums\Audience;
use App\Enums\Category;

trait HasMetadata
{
    /** @var string[] */
    public array $grades = [];
    /** @var string[] */
    public array $standards = [];
    /** @var string[] */
    public array $practices = [];
    /** @var string[] */
    public array $languages = [];
    public string $category;
    public string $audience;

    public function mountHasMetadata(): void
    {
        $this->grades = [];
        $this->standards = [];
        $this->practices = [];
        $this->languages = [];
        $this->category = Category::material()->value;
        $this->audience = Audience::students()->value;
    }

    /** @return array<string, string[]|string> */
    public function getMetadata()
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
}
