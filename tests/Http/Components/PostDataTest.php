<?php

namespace Http\Components;

use PHPUnit\Framework\TestCase;
use LunarisForge\Http\Components\PostData;

class PostDataTest extends TestCase
{
    /**
     * @var array<mixed>
     */
    protected array $originalPost;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        $this->originalPost = $_POST;
    }

    /**
     * @return void
     */
    protected function tearDown(): void
    {
        $_POST = $this->originalPost;
    }

    /**
     * @return void
     */
    public function testGetPostData(): void
    {
        $postData = new PostData(['username' => 'Alice', 'password' => 'secret']);
        $this->assertEquals('Alice', $postData->get('username'));
        $this->assertEquals('secret', $postData->get('password'));
        $this->assertNull($postData->get('nonexistent'));
        $this->assertEquals('default', $postData->get('nonexistent', 'default'));
    }

    /**
     * @return void
     */
    public function testAllPostData(): void
    {
        $postData = new PostData(['username' => 'Alice', 'password' => 'secret']);
        $this->assertEquals(['username' => 'Alice', 'password' => 'secret'], $postData->all());
    }

    /**
     * @return void
     */
    public function testDefaultToGlobalPost(): void
    {
        $_POST['username'] = 'Alice';
        $_POST['password'] = 'secret';

        $postData = new PostData();
        $this->assertEquals('Alice', $postData->get('username'));
        $this->assertEquals('secret', $postData->get('password'));
        $this->assertEquals(['username' => 'Alice', 'password' => 'secret'], $postData->all());
    }
}
