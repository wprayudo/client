<?php

namespace Bee\Client\Request;

class PingRequest implements Request
{
    public function getType()
    {
        return self::TYPE_PING;
    }

    public function getBody()
    {
    }
}
