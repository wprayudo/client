<?php

namespace Bee\Client\Tests\Integration\FakeServer\Handler;

class ChainHandler implements Handler
{
    private $handlers;

    public function __construct(array $handlers)
    {
        $this->handlers = $handlers;
    }

    public function __invoke($conn, $sid)
    {
        foreach ($this->handlers as $handler) {
            if (false === $handler($conn, $sid)) {
                break;
            }
        }
    }
}
