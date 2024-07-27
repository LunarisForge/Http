<?php

namespace LunarisForge\Http;

use Exception;
use LunarisForge\Http\Enums\HttpStatus;
use LunarisForge\Http\Components\Header;
use LunarisForge\Http\Components\Cookie;

class Response
{
    /**
     * @var resource|false
     */
    protected $body;

    /**
     * @var Header
     */
    protected Header $headers;

    /**
     * @var Cookie
     */
    protected Cookie $cookies;

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

        $this->headers = new Header();
        $this->cookies = new Cookie();
    }

    /**
     * Set a header for the response.
     *
     * @param  string  $name
     * @param  string  $value
     * @return void
     */
    public function setHeader(string $name, string $value): void
    {
        $this->headers->set($name, $value);
    }

    /**
     * Get a header value for the response.
     *
     * @param  string  $name
     * @return mixed
     */
    public function getHeader(string $name): mixed
    {
        return $this->headers->get($name);
    }

    /**
     * Set a cookie for the response.
     *
     * @param  string  $name
     * @param  string  $value
     * @param  int  $expires
     * @param  string  $path
     * @param  string  $domain
     * @param  bool  $secure
     * @param  bool  $httponly
     *
     * @return void
     */
    public function setCookie(
        string $name,
        string $value = "",
        int $expires = 0,
        string $path = "",
        string $domain = "",
        bool $secure = false,
        bool $httponly = false
    ): void {
        $this->cookies->set($name, $value, $expires, $path, $domain, $secure, $httponly);
    }

    /**
     * Get a cookie value for the response.
     *
     * @param  string  $name
     *
     * @return mixed
     */
    public function getCookie(string $name): mixed
    {
        return $this->cookies->get($name);
    }

    /**
     * @return void
     */
    public function send(): void
    {
        http_response_code($this->getStatusCode());

        foreach ($this->headers->all() as $name => $value) {
            header($name . ': ' . $value);
        }

        foreach ($this->cookies->all() as $name => $data) {
            if (is_array($data) && isset($data['value'])) {
                setcookie(
                    $name,
                    (string)$data['value'],
                    [
                        'expires' => (int)$data['expires'],
                        'path' => $data['path'],
                        'domain' => $data['domain'],
                        'secure' => (bool)$data['secure'],
                        'httponly' => (bool)$data['httponly'],
                    ]
                );
            }
        }

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
