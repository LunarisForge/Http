<?php

namespace LunarisForge\Http;

class Response
{
    /**
     * @var string
     */
    protected string $content;

    /**
     * @var int
     */
    protected int $status;

    /**
     * @param  string  $content
     * @param  int  $status
     */
    public function __construct(string $content, int $status = 200)
    {
        $this->content = $content;
        $this->status = $status;
    }

    /**
     * @return void
     */
    public function send(): void
    {
        http_response_code($this->status);
        echo $this->content;
    }
}