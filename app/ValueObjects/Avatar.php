<?php

declare(strict_types=1);

namespace App\ValueObjects;

use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

/**
 * \App\ValueObjects\Avatar
 *
 * This class represents the Avatar value object. It wraps the avatar property of the user
 * into a rich object that can be used to perform operations on the avatar property.
 */
class Avatar implements \Stringable
{
    private string $path;

    private ?string $default;

    /**
     * @var FilesystemAdapter
     */
    private $storage;

    public function __construct(string $path, string $disk = 'public')
    {
        $this->path = $path;
        $this->default = null;
        $this->storage = Storage::disk($disk);
    }

    public function setDefault(string $default): void
    {
        $this->default = $default;
    }

    /**
     * Create an Avatar object from an uploaded file
     *
     * @param  ?UploadedFile  $file  The uploaded file
     */
    public static function fromUploadedFile($file, string $disk = 'public'): self
    {
        if (is_null($file)) {
            return new self('');
        }

        $path = $file->store('avatars', $disk);
        if (! $path) {
            return new self('');
        }

        return new self($path, $disk);
    }

    public function path(): string
    {
        return $this->path;
    }

    public function delete(): bool
    {
        return $this->storage->delete($this->path);
    }

    public function url(): ?string
    {
        // return $this->exists()
        // ? $this->storage->url($this->path)
        // : $this->default;
        return $this->default;
    }

    public function exists(): bool
    {
        return $this->storage->exists($this->path);
    }

    public function __toString(): string
    {
        return $this->url() ?? '';
    }
}
