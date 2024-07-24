<?php

namespace Http\Components;

use PHPUnit\Framework\TestCase;
use LunarisForge\Http\Components\QueryParameter;

class QueryParameterTest extends TestCase
{
    /**
     * @var array<mixed>
     */
    protected array $originalGet;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        $this->originalGet = $_GET;
    }

    /**
     * @return void
     */
    protected function tearDown(): void
    {
        $_GET = $this->originalGet;
    }

    /**
     * @return void
     */
    public function testGetQueryParam(): void
    {
        $queryParams = new QueryParameter(['name' => 'John', 'age' => '30']);
        $this->assertEquals('John', $queryParams->get('name'));
        $this->assertEquals('30', $queryParams->get('age'));
        $this->assertNull($queryParams->get('nonexistent'));
        $this->assertEquals('default', $queryParams->get('nonexistent', 'default'));
    }

    /**
     * @return void
     */
    public function testAllQueryParams(): void
    {
        $queryParams = new QueryParameter(['name' => 'John', 'age' => '30']);
        $this->assertEquals(['name' => 'John', 'age' => '30'], $queryParams->all());
    }

    /**
     * @return void
     */
    public function testDefaultToGlobalGet(): void
    {
        $_GET['name'] = 'John';
        $_GET['age'] = '30';

        $queryParams = new QueryParameter();
        $this->assertEquals('John', $queryParams->get('name'));
        $this->assertEquals('30', $queryParams->get('age'));
        $this->assertEquals(['name' => 'John', 'age' => '30'], $queryParams->all());
    }
}
