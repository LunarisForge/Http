<?php

namespace Tests\Http;

use LunarisForge\Http\Request;
use PHPUnit\Framework\TestCase;

class RequestTest extends TestCase
{
    /**
     * @return void
     */
    public function testCaptureReturnsInstanceOfRequest(): void
    {
        $request = Request::capture();
        $this->assertInstanceOf(Request::class, $request);
    }

    /**
     * @return void
     */
    public function testGetMethodReturnsCorrectMethod(): void
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $request = new Request();
        $this->assertEquals('POST', $request->getMethod());
    }

    /**
     * @return void
     */
    public function testGetPathReturnsCorrectPath(): void
    {
        $_SERVER['REQUEST_URI'] = '/test/path?query=string';
        $request = new Request();
        $this->assertEquals('/test/path', $request->getPath());
    }

    /**
     * @return void
     */
    public function testGetPathReturnsFalseOnInvalidURI(): void
    {
        $_SERVER['REQUEST_URI'] = 'http:///example.com';
        $request = new Request();
        $this->assertFalse($request->getPath());
    }
}
