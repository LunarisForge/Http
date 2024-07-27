<?php

namespace LunarisForge\Http\Components;

use LunarisForge\Http\Interfaces\Component;

class QueryParameter implements Component
{
    /**
     * @param  array<mixed>  $queryParams
     */
    public function __construct(protected array $queryParams = [])
    {
        $this->queryParams = $queryParams ?: $_GET;
    }

    /**
     * {@inheritDoc}
     */
    public function set(string $name, mixed $value): void
    {
        $this->queryParams[$name] = $value;
    }

    /**
     * {@inheritDoc}
     */
    public function get(string $key, mixed $default = null): mixed
    {
        return $this->queryParams[$key] ?? $default;
    }

    /**
     * {@inheritDoc}
     */
    public function all(): array
    {
        return $this->queryParams;
    }
}
