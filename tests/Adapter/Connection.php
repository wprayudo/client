<?php

namespace Bee\Client\Tests\Adapter;

use Bee\Client\Connection\Connection as BaseConnection;

class Connection implements BaseConnection
{
    private $bee;

    public function __construct(\Bee $beenool)
    {
        $this->bee = $beenool;
    }

    public function open()
    {
        $this->bee->connect();
    }

    public function close()
    {
        $this->bee->close();
    }

    public function isClosed()
    {
        throw new \RuntimeException(sprintf('"%s" is not supported.', __METHOD__));
    }

    public function send($data)
    {
        throw new \RuntimeException(sprintf('"%s" is not supported.', __METHOD__));
    }
}
