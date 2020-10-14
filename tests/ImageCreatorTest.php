<?php

use PHPUnit\Framework\TestCase;
use CCT\Services\HtmlToImage\ImageCreator;
use GuzzleHttp\Client;
use CCT\Services\HtmlToImage\Client as HtmlToImageClient;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Handler\MockHandler;
use function GuzzleHttp\Psr7\stream_for;

class ImageCreatorTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
    }

    public function testCreateFromUrl()
    {
        $stream = stream_for(file_get_contents(__DIR__ . '/Mock/successCreate.json'));
        $successfulImageCreate = new Response(200, ['Content-Type' => 'application/json'], $stream);

        $mock = new MockHandler([
            $successfulImageCreate,
        ]);

        $handler = HandlerStack::create($mock);
        $mockHttpClient = new Client(['handler' => $handler]);

        $client = new  HtmlToImageClient($mockHttpClient,
            'username',
            'password');

        $imageCreator = new ImageCreator($client);
        $url = $imageCreator->createFromUrl('https://test.com');

        $this->assertEquals('https://hcti.io/v1/image/7180a4ac-ddca-477a-a59e-9cbb33b4bc4b', $url);
    }

    public function testCreateFromUrlWithAdditionalParameters()
    {
        $stream = stream_for(file_get_contents(__DIR__ . '/Mock/successCreate.json'));
        $successfulImageCreate = new Response(200, ['Content-Type' => 'application/json'], $stream);

        $mock = new MockHandler([
            $successfulImageCreate,
        ]);

        $handler = HandlerStack::create($mock);
        $mockHttpClient = new Client(['handler' => $handler]);

        $client = new  HtmlToImageClient($mockHttpClient,
            'username',
            'password');

        $imageCreator = new ImageCreator($client);
        $url = $imageCreator->createFromUrl(
            'https://test.com',
            [
                "full_screen" => true
            ]
        );

        $this->assertEquals('https://hcti.io/v1/image/7180a4ac-ddca-477a-a59e-9cbb33b4bc4b', $url);
    }

    public function testCreateFromHtml()
    {
        $stream = stream_for(file_get_contents(__DIR__ . '/Mock/successCreate.json'));
        $successfulImageCreate = new Response(200, ['Content-Type' => 'application/json'], $stream);

        $mock = new MockHandler([
            $successfulImageCreate,
        ]);

        $handler = \GuzzleHttp\HandlerStack::create($mock);
        $mockHttpClient = new Client(['handler' => $handler]);

        $client = new  HtmlToImageClient($mockHttpClient,
            'username',
            'password');

        $imageCreator = new ImageCreator($client);
        $url = $imageCreator->createFromHtml('<html><body><h1>Test Html<h1></body></html>', 'h1{ font-size:10px;}');

        $this->assertEquals('https://hcti.io/v1/image/7180a4ac-ddca-477a-a59e-9cbb33b4bc4b', $url);
    }

    public function testDeleteImage()
    {
        $stream = stream_for(file_get_contents(__DIR__ . '/Mock/successDelete.json'));
        $successfulImageDelete = new Response(202, ['Content-Type' => 'application/json'], $stream);

        $mock = new MockHandler([
            $successfulImageDelete
        ]);

        $handler = HandlerStack::create($mock);
        $mockHttpClient = new Client(['handler' => $handler]);

        $client = new  HtmlToImageClient($mockHttpClient,
            'username',
            'password');

        $imageCreator = new ImageCreator($client);

        $this->assertEquals(true, $imageCreator->deleteImage('81b4ec75-de84-4cf7-933b-da079b9836ed'));
    }
}