<?php

namespace Tests\Http;

use LunarisForge\Http\Response;
use PHPUnit\Framework\TestCase;

class ResponseTest extends TestCase
{
    /**
     * @return void
     */
    public function testGetContent(): void
    {
        $response = new Response('Test content');
        $this->assertEquals('Test content', $response->getContent());
    }

    /**
     * @return void
     */
    public function testGetStatusCode(): void
    {
        $response = new Response('Test content', 404);
        $this->assertEquals(404, $response->getStatusCode());

        $response = new Response('Test content');
        $this->assertEquals(200, $response->getStatusCode());
    }

    /**
     * @return void
     */
    public function testSendOutputsContentAndSetsStatus(): void
    {
        $response = new Response('Test content', 404);

        // Start output buffering
        ob_start();
        $response->send();
        $output = ob_get_clean();

        $this->assertEquals('Test content', $output);
        $this->assertEquals(404, http_response_code());
    }
}
