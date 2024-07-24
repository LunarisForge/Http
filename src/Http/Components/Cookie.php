<?php

namespace LunarisForge\Http\Components;

use LunarisForge\Http\Interfaces\Component;

class Cookie implements Component
{
    /**
     * @param  array<mixed>  $cookies
     */
    public function __construct(protected array $cookies = [])
    {
        $this->cookies = $cookies ?: $_COOKIE;
    }

    /**
     * {@inheritDoc}
     */
    public function get(string $key, mixed $default = null): mixed
    {
        return $this->cookies[$key] ?? $default;
    }

    /**
     * {@inheritDoc}
     */
    public function all(): array
    {
        return $this->cookies;
    }
}
