<?php

namespace Http;

use LunarisForge\Http\Enums\HttpStatus;
use LunarisForge\Http\Response;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

class ResponseTest extends TestCase
{
    /**
     * @return void
     */
    public function testConstructorSetsContentAndStatus(): void
    {
        $response = new Response('Test content', HttpStatus::NOT_FOUND);

        $body = $response->getBody();
        $this->assertIsResource($body, 'The body should be a valid resource.');

        rewind($body);
        $this->assertEquals('Test content', stream_get_contents($body));
        $this->assertEquals(404, $response->getStatusCode());
    }

    /**
     * @return void
     */
    public function testSendOutputsContentAndSetsStatus(): void
    {
        $response = new Response('Test content', HttpStatus::NOT_FOUND);

        // Start output buffering
        ob_start();
        $response->send();
        $output = ob_get_clean();

        $this->assertEquals('Test content', $output);
        $this->assertEquals(404, http_response_code());
    }

    /**
     * @return void
     */
    public function testGetContents(): void
    {
        $response = new Response('Test content');
        $this->assertEquals('Test content', $response->getContents());
    }

    /**
     * @return void
     */
    public function testGetStatusCode(): void
    {
        $response = new Response('Test content', HttpStatus::NOT_FOUND);
        $this->assertEquals(404, $response->getStatusCode());

        $response = new Response('Test content');
        $this->assertEquals(200, $response->getStatusCode());
    }

    /**
     * @return void
     */
    public function testGetStatusMessage(): void
    {
        $response = new Response('Test content', HttpStatus::NOT_FOUND);
        $this->assertEquals('Not Found', $response->getStatusMessage());

        $response = new Response('Test content');
        $this->assertEquals('OK', $response->getStatusMessage());
    }

    /**
     * @return void
     */
    public function testGetBody(): void
    {
        $response = new Response('Test content');
        $body = $response->getBody();
        $this->assertIsResource($body, 'The body should be a valid resource.');

        rewind($body);
        $this->assertEquals('Test content', stream_get_contents($body));
    }

    /**
     * @return void
     */
    public function testGetContentsWhenBodyIsNotAResource(): void
    {
        $response = new Response('Test content');

        // Simulating edge case ... set body to false
        $reflection = new ReflectionClass($response);
        $property = $reflection->getProperty('body');
        $property->setValue($response, false);

        $this->assertFalse($response->getContents());
    }

    /**
     * @return void
     */
    public function testSetHeader(): void
    {
        $response = new Response('Test content');
        $response->setHeader('X-Test-Header', 'TestValue');

        // Start output buffering
        ob_start();
        $response->send();
        ob_end_clean();

        $headers = xdebug_get_headers();
        $this->assertContains('X-Test-Header: TestValue', $headers);
    }

    /**
     * @return void
     */
    public function testSetCookie(): void
    {
        $response = new Response('Test content');
        $expiry = time() + 3600;
        $response->setCookie('TestCookie', 'TestValue', $expiry, '/', 'example.com', true, true);

        // Start output buffering
        ob_start();
        $response->send();
        ob_end_clean();

        $headers = xdebug_get_headers();
        $cookieHeader = $this->findCookieHeader($headers);
        $this->assertNotEmpty($cookieHeader, 'Set-Cookie header not found');

        $expectedAttributes = [
            'TestCookie=TestValue',
            'expires='.gmdate('D, d M Y H:i:s T', $expiry),
            'Max-Age=3600',
            'path=/',
            'domain=example.com',
            'secure',
            'HttpOnly',
        ];

        foreach ($expectedAttributes as $attribute) {
            $this->assertStringContainsString($attribute, $cookieHeader);
        }
    }

    /**
     * @param  array<string>  $headers
     *
     * @return string
     */
    private function findCookieHeader(array $headers): string
    {
        foreach ($headers as $header) {
            if (stripos($header, 'Set-Cookie: '.'TestCookie'.'=') === 0) {
                return $header;
            }
        }
        return '';
    }
}
