<?php

namespace Http\Components;

use PHPUnit\Framework\TestCase;
use LunarisForge\Http\Components\ServerParameter;

class ServerParameterTest extends TestCase
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
    public function testGetServerParam(): void
    {
        $serverParams = new ServerParameter(['REQUEST_METHOD' => 'GET', 'REQUEST_URI' => '/home']);
        $this->assertEquals('GET', $serverParams->get('REQUEST_METHOD'));
        $this->assertEquals('/home', $serverParams->get('REQUEST_URI'));
        $this->assertNull($serverParams->get('nonexistent'));
        $this->assertEquals('default', $serverParams->get('nonexistent', 'default'));
    }

    /**
     * @return void
     */
    public function testAllServerParams(): void
    {
        $serverParams = new ServerParameter(['REQUEST_METHOD' => 'GET', 'REQUEST_URI' => '/home']);
        $this->assertEquals(['REQUEST_METHOD' => 'GET', 'REQUEST_URI' => '/home'], $serverParams->all());
    }

    /**
     * @return void
     */
    public function testDefaultToGlobalServer(): void
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['REQUEST_URI'] = '/home';

        $serverParams = new ServerParameter();
        $this->assertEquals('GET', $serverParams->get('REQUEST_METHOD'));
        $this->assertEquals('/home', $serverParams->get('REQUEST_URI'));
    }
}
