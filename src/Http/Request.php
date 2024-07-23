<?php

namespace LunarisForge\Http;

class Request
{
    /**
     * @return self
     */
    public static function capture(): self
    {
        return new self();
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    /**
     * @return string|false|null
     */
    public function getPath(): string|false|null
    {
        return parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    }
}
