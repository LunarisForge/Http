<?php

namespace LunarisForge\Http\Components;

use LunarisForge\Http\Interfaces\Component;

class PostData implements Component
{
    /**
     * @param  array<mixed>  $postData
     */
    public function __construct(protected array $postData = [])
    {
        $this->postData = $postData ?: $_POST;
    }

    /**
     * {@inheritDoc}
     */
    public function set(string $name, mixed $value): void
    {
        $this->postData[$name] = $value;
    }

    /**
     * {@inheritDoc}
     */
    public function get(string $key, mixed $default = null): mixed
    {
        return $this->postData[$key] ?? $default;
    }

    /**
     * {@inheritDoc}
     */
    public function all(): array
    {
        return $this->postData;
    }
}
