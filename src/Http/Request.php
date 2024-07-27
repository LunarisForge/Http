<?php

namespace LunarisForge\Http;

use InvalidArgumentException;
use LunarisForge\Http\Components\Cookie;
use LunarisForge\Http\Components\File;
use LunarisForge\Http\Components\Header;
use LunarisForge\Http\Components\PostData;
use LunarisForge\Http\Components\QueryParameter;
use LunarisForge\Http\Components\ServerParameter;
use LunarisForge\Http\Enums\HttpMethod;
use LunarisForge\Http\Interfaces\Component;

class Request
{
    /**
     * @var Component|Header
     */
    protected Component|Header $header;

    /**
     * @var Component|QueryParameter
     */
    protected Component|QueryParameter $query;

    /**
     * @var Component|PostData
     */
    protected Component|PostData $post;

    /**
     * @var Component|Cookie
     */
    protected Component|Cookie $cookie;

    /**
     * @var Component|File
     */
    protected Component|File $files;

    /**
     * @var Component|ServerParameter
     */
    protected Component|ServerParameter $server;

    /**
     * @param  array<mixed>  $header
     * @param  array<mixed>  $query
     * @param  array<mixed>  $post
     * @param  array<mixed>  $cookie
     * @param  array<mixed>  $files
     * @param  array<mixed>  $server
     */
    public function __construct(
        array $header = [],
        array $query = [],
        array $post = [],
        array $cookie = [],
        array $files = [],
        array $server = [],
    ) {
        $this->header = new Header($header);
        $this->query = new QueryParameter($query);
        $this->post = new PostData($post);
        $this->cookie = new Cookie($cookie);
        $this->files = new File($files);
        $this->server = new ServerParameter($server);
    }

    /**
     * @return self
     */
    public static function capture(): self
    {
        return new self(
            header: [],
            query: $_GET,
            post: $_POST,
            cookie: $_COOKIE,
            files: $_FILES,
            server: $_SERVER,
        );
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        $requestMethod = $this->server->get('REQUEST_METHOD');

        if (!is_string($requestMethod) || !HttpMethod::tryFrom($requestMethod)) {
            throw new InvalidArgumentException('Invalid or unsupported HTTP method.');
        }

        return $requestMethod;
    }

    /**
     * @return array<mixed>|false|int|string|null
     */
    public function getPath(): false|int|array|string|null
    {
        $requestUri = $this->server->get('REQUEST_URI');

        if (!is_string($requestUri)) {
            throw new InvalidArgumentException('Invalid or unsupported request uri.');
        }

        return parse_url($requestUri, PHP_URL_PATH);
    }
}
