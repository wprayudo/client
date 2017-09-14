<?php

namespace Bee\Client\Tests\Unit\Packer;

use Bee\Client\Packer\PurePacker;

/**
 * @requires function MessagePack\Packer::pack
 */
class PurePackerTest extends PackerTest
{
    protected function createPacker()
    {
        return new PurePacker();
    }
}
