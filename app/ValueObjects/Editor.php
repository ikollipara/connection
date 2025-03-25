<?php

declare(strict_types=1);

namespace App\ValueObjects;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Js;
use JsonException;
use Override;

/**
 * @implements Arrayable<string, mixed>
 */
class Editor implements Arrayable
{
    /**
     * @var array<string, mixed>
     */
    protected array $data;

    /**
     * @param  array<string, mixed>  $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    #[Override]
    public function toArray()
    {
        return $this->data;
    }

    /**
     * @return ($parse is true ? Js : string)
     *
     * @throws JsonException
     */
    public function toJson(bool $parse = false)
    {
        if ($parse) {
            return Js::from($this->data);
        }

        return Js::encode($this->data);
    }

    public static function fromJson(string $json): self
    {
        return new self(json_decode($json, associative: true));
    }
}
