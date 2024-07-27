<?php

namespace LunarisForge\Http\Components;

use LunarisForge\Http\Interfaces\Component;

class Header implements Component
{
    /**
     * @param  array<mixed>  $headers
     */
    public function __construct(protected array $headers = [])
    {
        $this->headers = !empty($headers) ? $headers : $this->resolve();
    }

    /**
     * {@inheritDoc}
     */
    public function get(string $key, mixed $default = null): mixed
    {
        return $this->headers[$key] ?? $default;
    }

    /**
     * {@inheritDoc}
     */
    public function set(string $name, mixed $value): void
    {
        $this->headers[$name] = $value;
    }

    /**
     * {@inheritDoc}
     */
    public function all(): array
    {
        return $this->headers;
    }

    /**
     * Rebuild headers if @see getallheaders() is not supported
     *
     * @return array<mixed>
     */
    private function resolve(): array
    {
        if (function_exists('getallheaders')) {
            return getallheaders();
        }

        $headers = [];
        foreach ($_SERVER as $key => $value) {
            if (str_starts_with($key, 'HTTP_')) {
                $header = str_replace('_', ' ', mb_substr($key, 5));
                $header = ucwords(mb_strtolower($header));
                $header = str_replace(' ', '-', $header);
                $headers[$header] = $value;
            }
        }

        return $headers;
    }
}
