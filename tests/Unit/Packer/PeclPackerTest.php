<?php

namespace Bee\Client\Tests\Unit\Packer;

use Bee\Client\Packer\PeclPacker;

/**
 * @requires extension msgpack
 * @requires function MessagePackUnpacker::__construct
 */
class PeclPackerTest extends PackerTest
{
    protected function createPacker()
    {
        return new PeclPacker();
    }
}
