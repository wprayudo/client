<?php

namespace Bee\Client\Tests\Unit;

use Bee\Client\IProto;

class IProtoTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider \Bee\Client\Tests\GreetingDataProvider::provideValidGreetings
     */
    public function testParseGreeting($greeting, $salt)
    {
        $this->assertSame($salt, IProto::parseGreeting($greeting));
    }

    /**
     * @dataProvider \Bee\Client\Tests\GreetingDataProvider::provideGreetingsWithInvalidServerName
     *
     * @expectedException \Bee\Client\Exception\Exception
     * @expectedExceptionMessage Invalid greeting: unable to recognize Bee server.
     */
    public function testParseGreetingThrowsExceptionOnInvalidServer($greeting)
    {
        IProto::parseGreeting($greeting);
    }

    /**
     * @dataProvider \Bee\Client\Tests\GreetingDataProvider::provideGreetingsWithInvalidSalt
     *
     * @expectedException \Bee\Client\Exception\Exception
     * @expectedExceptionMessage Invalid greeting: unable to parse salt.
     */
    public function testParseGreetingThrowsExceptionOnInvalidSalt($greeting)
    {
        IProto::parseGreeting($greeting);
    }
}
