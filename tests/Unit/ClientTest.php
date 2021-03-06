<?php

namespace Bee\Client\Tests\Unit;

use Bee\Client\Client;
use Bee\Client\Connection\Connection;
use Bee\Client\Packer\Packer;
use Bee\Client\Request\Request;
use Bee\Client\Response;
use Bee\Client\Tests\Assert;
use Bee\Client\Tests\PhpUnitCompat;

class ClientTest extends \PHPUnit_Framework_TestCase
{
    use Assert;
    use PhpUnitCompat;

    /**
     * @var \Bee\Client\Connection\Connection|\PHPUnit_Framework_MockObject_MockObject
     */
    private $connection;

    /**
     * @var \Bee\Client\Packer\Packer|\PHPUnit_Framework_MockObject_MockObject
     */
    private $packer;

    /**
     * @var Client
     */
    private $client;

    protected function setUp()
    {
        $this->connection = $this->createMock(Connection::class);
        $this->packer = $this->createMock(Packer::class);
        $this->client = new Client($this->connection, $this->packer);
    }

    public function testGetConnection()
    {
        $this->assertSame($this->connection, $this->client->getConnection());
    }

    public function testGetPacker()
    {
        $this->assertSame($this->packer, $this->client->getPacker());
    }

    /**
     * @dataProvider provideCallbackData
     */
    public function testOpenConnectionBeforeSend($methodName, array $methodArgs)
    {
        $this->connection->expects($this->once())->method('isClosed')
            ->will($this->returnValue(true));

        $this->connection->expects($this->once())->method('open');

        call_user_func_array([$this->client, $methodName], $methodArgs);
    }

    /**
     * @dataProvider provideCallbackData
     */
    public function testPackUnpackMessage($methodName, array $methodArgs)
    {
        $response = $this->createMock(Response::class);

        $this->packer->expects($this->once())->method('pack')
            ->with($this->isInstanceOf(Request::class))
            ->will($this->returnValue($this->isType('string')));

        $this->packer->expects($this->once())->method('unpack')
            ->will($this->returnValue($response));

        $response = call_user_func_array([$this->client, $methodName], $methodArgs);

        $this->assertResponse($response);
    }

    public function provideCallbackData()
    {
        return [
            ['ping', []],
            ['call', ['box.stat']],
            ['evaluate', ['return 42']],
            ['sendRequest', [$this->createMock(Request::class)]],
        ];
    }
}
