<?php

namespace CCT\Services\HtmlToImage;


class Client
{
    /**
     * @var \GuzzleHttp\Client
     */
    private $client;
    /**
     * @var string
     */
    private $username;
    /**
     * @var string
     */
    private $password;

    public function __construct(\GuzzleHttp\Client $client, string $username, string $password)
    {
        $this->client = $client;
        $this->username = $username;
        $this->password = $password;
    }

    public function request(string $method, string $uri, array $options = [])
    {
        $options = array_merge($options, ['auth' => [$this->username, $this->password]]);
        return $this->client->request($method, $uri, $options);
    }
}