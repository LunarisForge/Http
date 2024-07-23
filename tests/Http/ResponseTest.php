<?php

namespace Tests\Http;

use LunarisForge\Http\Response;
use PHPUnit\Framework\TestCase;

class ResponseTest extends TestCase
{
    /**
     * @return void
     */
    public function testConstructorSetsContentAndStatus(): void
    {
        $response = new Response('Test content', 404);

        $reflection = new \ReflectionClass($response);

        $contentProperty = $reflection->getProperty('content');
        $contentProperty->setAccessible(true);
        $this->assertEquals('Test content', $contentProperty->getValue($response));

        $statusProperty = $reflection->getProperty('status');
        $statusProperty->setAccessible(true);
        $this->assertEquals(404, $statusProperty->getValue($response));
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
