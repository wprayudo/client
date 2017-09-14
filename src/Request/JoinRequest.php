<?php

namespace Bee\Client\Request;

use Bee\Client\IProto;

class JoinRequest implements Request
{
    private $serverUuid;

    public function __construct($serverUuid)
    {
        $this->serverUuid = $serverUuid;
    }

    public function getType()
    {
        return self::TYPE_JOIN;
    }

    public function getBody()
    {
        return [
            IProto::SERVER_UUID => $this->serverUuid,
        ];
    }
}
