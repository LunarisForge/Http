<?php

namespace Http\Enums;

use LunarisForge\Http\Enums\HttpMethod;
use PHPUnit\Framework\TestCase;

class HttpMethodTest extends TestCase
{
    /**
     * @return void
     */
    public function testGetValue(): void
    {
        $this->assertEquals('GET', HttpMethod::GET->value);
        $this->assertEquals('POST', HttpMethod::POST->value);
        $this->assertEquals('PATCH', HttpMethod::PATCH->value);
        $this->assertEquals('DELETE', HttpMethod::DELETE->value);
        $this->assertEquals('OPTIONS', HttpMethod::OPTIONS->value);
        $this->assertEquals('PUT', HttpMethod::PUT->value);
        $this->assertEquals('HEAD', HttpMethod::HEAD->value);
        $this->assertEquals('TRACE', HttpMethod::TRACE->value);
    }

    /**
     * @return void
     */
    public function testEnumCases(): void
    {
        $cases = HttpMethod::cases();
        $expected = [
            HttpMethod::GET,
            HttpMethod::POST,
            HttpMethod::PATCH,
            HttpMethod::DELETE,
            HttpMethod::OPTIONS,
            HttpMethod::PUT,
            HttpMethod::HEAD,
            HttpMethod::TRACE,
        ];

        $this->assertEquals($expected, $cases);
    }
}
