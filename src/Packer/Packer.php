<?php

namespace Bee\Client\Packer;

use Bee\Client\Request\Request;

interface Packer
{
    /**
     * @param Request $request
     * @param int|null $sync
     *
     * @return string
     */
    public function pack(Request $request, $sync = null);

    /**
     * @param string $data
     *
     * @return \Bee\Client\Response
     *
     * @throws \Bee\Client\Exception\Exception
     */
    public function unpack($data);
}
