<?php

namespace LunarisForge\Http;

class Response
{
    /**
     * @param  string  $content
     * @param  int  $statusCode
     */
    public function __construct(protected string $content, protected int $statusCode = 200)
    {
    }

    /**
     * @return void
     */
    public function send(): void
    {
        http_response_code($this->getStatusCode());
        echo $this->content;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }
}