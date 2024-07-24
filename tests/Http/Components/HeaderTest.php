<?php

namespace Http\Components;

use PHPUnit\Framework\TestCase;
use LunarisForge\Http\Components\Header;

class HeaderTest extends TestCase
{
    /**
     * @var array<mixed>
     */
    protected array $originalServer;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        $this->originalServer = $_SERVER;
    }

    /**
     * @return void
     */
    protected function tearDown(): void
    {
        $_SERVER = $this->originalServer;
    }

    /**
     * @return void
     */
    public function testGetHeader(): void
    {
        $headers = new Header(['Content-Type' => 'application/json']);
        $this->assertEquals('application/json', $headers->get('Content-Type'));
        $this->assertNull($headers->get('Non-Existent-Header'));
        $this->assertEquals('default', $headers->get('Non-Existent-Header', 'default'));
    }

    /**
     * @return void
     */
    public function testAllHeaders(): void
    {
        $headers = new Header(['Content-Type' => 'application/json', 'Accept' => 'application/xml']);
        $this->assertEquals(['Content-Type' => 'application/json', 'Accept' => 'application/xml'], $headers->all());
    }

    /**
     * @return void
     */
    public function testResolveHeaders(): void
    {
        // Simulate the absence of getallheaders function
        if (function_exists('getallheaders')) {
            $this->markTestSkipped('The getallheaders function exists.');
        }

        $_SERVER['HTTP_CONTENT_TYPE'] = 'application/json';
        $_SERVER['HTTP_ACCEPT'] = 'application/xml';

        $headers = new Header();

        $this->assertEquals('application/json', $headers->get('Content-Type'));
        $this->assertEquals('application/xml', $headers->get('Accept'));
        $this->assertEquals(['Content-Type' => 'application/json', 'Accept' => 'application/xml'], $headers->all());
    }
}
