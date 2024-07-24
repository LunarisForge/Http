<?php

namespace Http\Components;

use PHPUnit\Framework\TestCase;
use LunarisForge\Http\Components\Cookie;

class CookieTest extends TestCase
{
    /**
     * @var array<mixed>
     */
    protected array $originalCookie;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        $this->originalCookie = $_COOKIE;
    }

    /**
     * @return void
     */
    protected function tearDown(): void
    {
        $_COOKIE = $this->originalCookie;
    }

    /**
     * @return void
     */
    public function testGetCookie(): void
    {
        $cookies = new Cookie(['user' => 'Alice', 'session' => 'abc123']);
        $this->assertEquals('Alice', $cookies->get('user'));
        $this->assertEquals('abc123', $cookies->get('session'));
        $this->assertNull($cookies->get('nonexistent'));
        $this->assertEquals('default', $cookies->get('nonexistent', 'default'));
    }

    /**
     * @return void
     */
    public function testAllCookies(): void
    {
        $cookies = new Cookie(['user' => 'Alice', 'session' => 'abc123']);
        $this->assertEquals(['user' => 'Alice', 'session' => 'abc123'], $cookies->all());
    }

    /**
     * @return void
     */
    public function testDefaultToGlobalCookie(): void
    {
        $_COOKIE['user'] = 'Alice';
        $_COOKIE['session'] = 'abc123';

        $cookies = new Cookie();
        $this->assertEquals('Alice', $cookies->get('user'));
        $this->assertEquals('abc123', $cookies->get('session'));
        $this->assertEquals(['user' => 'Alice', 'session' => 'abc123'], $cookies->all());
    }
}
