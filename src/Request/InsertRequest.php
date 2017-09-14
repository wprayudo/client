<?php

namespace Bee\Client\Request;

use Bee\Client\IProto;

class InsertRequest implements Request
{
    private $spaceId;
    private $values;

    public function __construct($spaceId, array $values)
    {
        $this->spaceId = $spaceId;
        $this->values = $values;
    }

    public function getType()
    {
        return self::TYPE_INSERT;
    }

    public function getBody()
    {
        return [
            IProto::SPACE_ID => $this->spaceId,
            IProto::TUPLE => $this->values,
        ];
    }
}
