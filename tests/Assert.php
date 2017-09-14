<?php

namespace Bee\Client\Tests;

trait Assert
{
    protected function assertResponse($response)
    {
        $this->assertInstanceOf('Bee\Client\Response', $response);
    }
}
