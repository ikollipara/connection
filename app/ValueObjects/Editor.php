<?php

declare(strict_types=1);

namespace App\ValueObjects;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Js;

class Editor implements Arrayable
{
    protected array $data;


    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function toArray()
    {
        return $this->data;
    }

    public function toJson(bool $parse = false)
    {
        if ($parse) {
            return Js::from($this->data);
        }

        return Js::encode($this->data);
    }

    public static function fromJson(string $json)
    {
        return new self(json_decode($json, associative: true));
    }
}
