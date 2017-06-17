<?php

namespace App\Components;

use Elasticsearch\Client;

class Elastic
{
    protected $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Index a single item
     *
     * @param  array  $parameters [index, type, id, body]
     */
    public function index(array $parameters)
    {
        return $this->client->index($parameters);
    }

    /**
     * Delete a single item
     *
     * @param  array  $parameters
     */
    public function delete(array $parameters)
    {
        return $this->client->delete($parameters);
    }

    /**
     * Index multiple items
     *
     * This method normalises the 'bulk' method of the Elastic Search
     * Client to have a signature more similar to 'index'
     *
     * @param  array  $collection [[index, type, id, body], [index, type, id, body]...]
     */
    public function indexMany(array $collection)
    {
        $parameters = [];

        foreach ($collection as $item) {
            $parameters['body'][] = [
                "index" => [
                    '_id' => $item['id'],
                    '_index' => $item['index'],
                    '_type' => $item['type'],
                ]
            ];

            $parameters['body'][] = $item['body'];
        }

        return $this->client->bulk($parameters);
    }

    /**
     * Delete Index
     *
     * This suppresses any exceptions thrown by trying
     * to delete a non-existent index by first
     * checking if it exists, then deleting.
     *
     * @param  string $name
     * @return bool
     */
    public function deleteIndex($name)
    {
        if (! $this->indexExists($name)) {
            return true;
        }

        return $this->client->indices()->delete([
            'index' => $name
        ]);
    }

    public function indexExists($name)
    {
        return $this->client->indices()->exists(['index' => $name]);
    }

    public function search(array $parameters)
    {
        return $this->client->search($parameters);
    }

    public function getClient()
    {
        return $this->client;
    }
}