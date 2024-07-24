<?php

namespace LunarisForge\Http\Interfaces;

interface Component
{
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
