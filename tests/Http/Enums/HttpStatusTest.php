<?php

namespace Http\Enums;

use PHPUnit\Framework\TestCase;
use LunarisForge\Http\Enums\HttpStatus;

class HttpStatusTest extends TestCase
{
    /**
     * Testing subset of codes
     *
     * @return void
     */
    public function testRepresentativeHttpStatusCodes(): void
    {
        $this->assertEquals(200, HttpStatus::OK->code());
        $this->assertEquals(201, HttpStatus::CREATED->code());
        $this->assertEquals(400, HttpStatus::BAD_REQUEST->code());
        $this->assertEquals(404, HttpStatus::NOT_FOUND->code());
        $this->assertEquals(500, HttpStatus::INTERNAL_SERVER_ERROR->code());
    }

    /**
     * Testing a subset of messages
     *
     * @return void
     */
    public function testRepresentativeHttpStatusMessage(): void
    {
        $this->assertEquals('OK', HttpStatus::OK->message());
        $this->assertEquals('Created', HttpStatus::CREATED->message());
        $this->assertEquals('Bad Request', HttpStatus::BAD_REQUEST->message());
        $this->assertEquals('Not Found', HttpStatus::NOT_FOUND->message());
        $this->assertEquals('Internal Server Error', HttpStatus::INTERNAL_SERVER_ERROR->message());
    }

    /**
     * @return void
     */
    public function testAllHttpStatusCases(): void
    {
        foreach (HttpStatus::cases() as $case) {
            $this->assertIsInt($case->code());
            $this->assertIsString($case->message());
        }
    }
}
