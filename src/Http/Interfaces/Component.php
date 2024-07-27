<?php

namespace LunarisForge\Http\Interfaces;

interface Component
{
    /**
     * @param  string  $name
     * @param  mixed  $value
     *
     * @return void
     */
    public function set(string $name, mixed $value): void;

    /**
     * @param  string  $key
     * @param  mixed|null  $default
     *
     * @return mixed
     */
    public function get(string $key, mixed $default = null): mixed;

    /**
     * @return array<mixed>
     */
    public function all(): array;
}
