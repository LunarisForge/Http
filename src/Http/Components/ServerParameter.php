<?php

namespace LunarisForge\Http\Components;

use LunarisForge\Http\Interfaces\Component;

class ServerParameter implements Component
{
    /**
     * @param  array<mixed>  $serverParams
     */
    public function __construct(protected array $serverParams = [])
    {
        $this->serverParams = $serverParams ?: $_SERVER;
    }

    /**
     * {@inheritDoc}
     */
    public function set(string $name, mixed $value): void
    {
        $this->serverParams[$name] = $value;
    }

    /**
     * {@inheritDoc}
     */
    public function get(string $key, mixed $default = null): mixed
    {
        return $this->serverParams[$key] ?? $default;
    }

    /**
     * {@inheritDoc}
     */
    public function all(): array
    {
        return $this->serverParams;
    }
}
