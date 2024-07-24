<?php

namespace LunarisForge\Http\Components;

use LunarisForge\Http\Interfaces\Component;

class File implements Component
{
    /**
     * @param  array<mixed>  $files
     */
    public function __construct(protected array $files = [])
    {
        $this->files = $files ?: $_FILES;
    }

    /**
     * {@inheritDoc}
     */
    public function get(string $key, mixed $default = null): mixed
    {
        return $this->files[$key] ?? $default;
    }

    /**
     * {@inheritDoc}
     */
    public function all(): array
    {
        return $this->files;
    }
}
