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

//        rewind($body);
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
}
