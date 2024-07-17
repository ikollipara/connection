<?php

namespace App\ValueObjects;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

/**
 * \App\ValueObjects\Avatar
 *
 * This class represents the Avatar value object. It wraps the avatar property of the user
 * into a rich object that can be used to perform operations on the avatar property.
 *
 */
class Avatar
{
    private string $path;
    private ?string $default;

    public function __construct(string $path)
    {
        $this->path = $path;
        $this->default = null;
    }

    public function setDefault(string $default): void
    {
        $this->default = $default;
    }

    /**
     * Create an Avatar object from an uploaded file
     * @param ?UploadedFile $file The uploaded file
     */
    public static function fromUploadedFile($file)
    {
        if ($file === null) {
            return new static("");
        }
        return new static($file->store("avatars", "public"));
    }

    public static function is($value): bool
    {
        return $value instanceof self;
    }

    public function path(): string
    {
        return $this->path;
    }

    public function delete(): bool
    {
        return Storage::disk("public")->delete($this->path);
    }

    public function url()
    {
        return $this->exists() ? Storage::url($this->path) : $this->default;
    }

    public function exists(): bool
    {
        return Storage::exists($this->path);
    }

    public function __toString(): string
    {
        return $this->url();
    }
}
