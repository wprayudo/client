<?php

namespace Bee\Client\Schema;

use Bee\Client\Client;
use Bee\Client\Exception\Exception;
use Bee\Client\Request\DeleteRequest;
use Bee\Client\Request\InsertRequest;
use Bee\Client\Request\ReplaceRequest;
use Bee\Client\Request\SelectRequest;
use Bee\Client\Request\UpdateRequest;
use Bee\Client\Request\UpsertRequest;

class Space
{
    const VSPACE = 281;
    const VINDEX = 289;

    private $client;
    private $id;
    private $indexes = [];

    public function __construct(Client $client, $id)
    {
        $this->client = $client;
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function select(array $key = null, $index = null, $limit = null, $offset = null, $iteratorType = null)
    {
        $key = null === $key ? [] : $key;
        $offset = null === $offset ? 0 : $offset;
        $limit = null === $limit ? PHP_INT_MAX & 0xffffffff : $limit;
        $iteratorType = null === $iteratorType ? 0 : $iteratorType;
        $index = $this->normalizeIndex($index);

        $request = new SelectRequest($this->id, $index, $key, $offset, $limit, $iteratorType);

        return $this->client->sendRequest($request);
    }

    public function insert(array $values)
    {
        $request = new InsertRequest($this->id, $values);

        return $this->client->sendRequest($request);
    }

    public function replace(array $values)
    {
        $request = new ReplaceRequest($this->id, $values);

        return $this->client->sendRequest($request);
    }

    public function update($key, array $operations, $index = null)
    {
        $index = $this->normalizeIndex($index);
        $request = new UpdateRequest($this->id, $index, $key, $operations);

        return $this->client->sendRequest($request);
    }

    public function upsert(array $values, array $operations)
    {
        $request = new UpsertRequest($this->id, $values, $operations);

        return $this->client->sendRequest($request);
    }

    public function delete(array $key, $index = null)
    {
        $index = $this->normalizeIndex($index);
        $request = new DeleteRequest($this->id, $index, $key);

        return $this->client->sendRequest($request);
    }

    public function flushIndexes()
    {
        $this->indexes = [];
    }

    private function getIndexIdByName($indexName)
    {
        if (isset($this->indexes[$indexName])) {
            return $this->indexes[$indexName];
        }

        $schema = $this->client->getSpace(Space::VINDEX);
        $response = $schema->select([$this->id, $indexName], Index::INDEX_NAME);
        $data = $response->getData();

        if (empty($data)) {
            throw new Exception("No index '$indexName' is defined in space #{$this->id}");
        }

        return $this->indexes[$indexName] = $response->getData()[0][1];
    }

    private function normalizeIndex($index)
    {
        if (null === $index) {
            return 0;
        }

        if (is_int($index)) {
            return $index;
        }

        return $this->getIndexIdByName($index);
    }
}
