<?php

namespace Http\Components;

use PHPUnit\Framework\TestCase;
use LunarisForge\Http\Components\File;

class FileTest extends TestCase
{
    /**
     * @var array<mixed>
     */
    protected array $originalFile;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        $this->originalFile = $_FILES;
    }

    /**
     * @return void
     */
    protected function tearDown(): void
    {
        $_FILES = $this->originalFile;
    }

    /**
     * @return void
     */
    public function testGetFile(): void
    {
        $files = new File(['file1' => ['name' => 'test.txt', 'size' => 123]]);
        $this->assertEquals(['name' => 'test.txt', 'size' => 123], $files->get('file1'));
        $this->assertNull($files->get('nonexistent'));
        $this->assertEquals(['name' => 'default.txt'], $files->get('nonexistent', ['name' => 'default.txt']));
    }

    /**
     * @return void
     */
    public function testAllFile(): void
    {
        $files = new File(['file1' => ['name' => 'test.txt', 'size' => 123]]);
        $this->assertEquals(['file1' => ['name' => 'test.txt', 'size' => 123]], $files->all());
    }

    /**
     * @return void
     */
    public function testDefaultToGlobalFile(): void
    {
        $_FILES['file1'] = ['name' => 'test.txt', 'size' => 123];

        $files = new File();
        $this->assertEquals(['name' => 'test.txt', 'size' => 123], $files->get('file1'));
        $this->assertEquals(['file1' => ['name' => 'test.txt', 'size' => 123]], $files->all());
    }
}
