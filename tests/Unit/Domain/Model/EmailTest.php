<?php


namespace Tests\Unit\Domain\Model;

use Notepad\Domain\Model\User\Email;
use PHPUnit\Framework\TestCase;

class EmailTest extends TestCase
{
    const EMAIL = 'artur@mindgeek.com';

    /**
     * @test
     */
    public function it_should_create_a_email_from_string()
    {
        $this->assertInstanceOf(Email::class, Email::create(self::EMAIL));
    }

    /**
     * @test
     */
    public function it_should_contain_the_same_string()
    {
        $stringTitle = self::EMAIL;
        $title = Email::create(self::EMAIL);
        $this->assertEquals($stringTitle, (string) $title);
    }

    /**
     * @test
     */
    public function it_should_not_allow_empty_title()
    {
        $this->expectException(\InvalidArgumentException::class);
        Email::create('');
    }

    /**
     * @test
     */
    public function it_should_not_allow_no_at()
    {
        $this->expectException(\InvalidArgumentException::class);
        Email::create('artrurnoat.com');
    }

    /**
     * @test
     */
    public function it_should_not_allow_no_extension()
    {
        $this->expectException(\InvalidArgumentException::class);
        Email::create('artrur@mindgeek');
    }
}