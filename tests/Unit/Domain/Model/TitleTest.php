<?php


namespace Tests\Unit\Domain\Model;

use Notepad\Domain\Model\Note\Title;
use PHPUnit\Framework\TestCase;

class TitleTest extends TestCase
{
    /**
     * @test
     */
    public function it_should_create_a_title_from_string()
    {
        $this->assertInstanceOf(Title::class, Title::create('test'));
    }

    /**
     * @test
     */
    public function it_should_contain_the_same_string()
    {
        $stringTitle = 'test';
        $title = Title::create('test');
        $this->assertEquals($stringTitle, (string) $title);
    }

    /**
     * @test
     */
    public function it_should_not_allow_empty_title()
    {
        $this->expectException(\InvalidArgumentException::class);
        Title::create('');
    }

    /**
     * @test
     */
    public function it_should_not_allow_title_bigger_than_20_chars()
    {
        $this->expectException(\InvalidArgumentException::class);
        Title::create('123456789012345678901');
    }
}