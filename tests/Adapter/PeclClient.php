<?php

namespace Bee\Client\Tests\Adapter;

use Bee\Client\Response;

class PeclClient
{
    private $bee;

    public function __construct($host, $port)
    {
        try {
            $this->bee = new \Bee($host, $port);
        } catch (\Exception $e) {
            throw ExceptionFactory::create($e);
        }
    }

    public function getConnection()
    {
        return new Connection($this->bee);
    }

    public function disconnect()
    {
        return $this->bee->close();
    }

    public function getSpace($space)
    {
        return new Space($this->bee, $space);
    }

    public function flushSpaces()
    {
        return $this->bee->flushSchema();
    }

    public function __call($method, array $args)
    {
        try {
            $result = call_user_func_array([$this->bee, $method], $args);
        } catch (\Exception $e) {
            throw ExceptionFactory::create($e);
        }

        if (is_bool($result)) {
            $result = [$result];
        }

        return new Response(0, $result);
    }
}
