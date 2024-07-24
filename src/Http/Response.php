<?php

namespace LunarisForge\Http;

use Exception;
use LunarisForge\Http\Enums\HttpStatus;

class Response
{
    /**
     * @var resource|false
     */
    protected $body;

    /**
     * @param  string  $content
     * @param  HttpStatus  $status
     * @throws Exception
     */
    public function __construct(protected string $content, protected HttpStatus $status = HttpStatus::OK)
    {
        $this->body = fopen('php://temp', 'rw');

        if ($this->body === false) {
            throw new Exception('Could not open the temporary file.');
        }

        fwrite($this->body, $this->content);
        rewind($this->body);
    }

    /**
     * @return void
     */
    public function send(): void
    {
        http_response_code($this->getStatusCode());
        echo $this->getContents();
    }

    /**
     * Get the stream representing the message body.
     *
     * @return resource|false
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Get the contents of the response body.
     *
     * @return string|false
     */
    public function getContents(): string|false
    {
        if (!is_resource($this->body)) {
            return false;
        }

        // Read remaining contents from the stream
        return stream_get_contents($this->body);
    }

    /**
     * Get the status code of the response.
     *
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->status->code();
    }

    /**
     * Get the status message of the response.
     *
     * @return string
     */
    public function getStatusMessage(): string
    {
        return $this->status->message();
    }
}
