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
    public function set(string $name, string $value, int $expiry = 0): void
    {
        $this->cookies[$name] = ['value' => $value, 'expiry' => $expiry];
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
