<?php
declare(strict_types=1);

namespace CCT\Services\HtmlToImage;

use CCT\Services\HtmlToImage\Exception\InvalidStatusCodeException;
use GuzzleHttp\RequestOptions;

class ImageCreator
{
    protected $client;

    /**
     * ImageCreator constructor.
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @param string $url
     * @param array $options
     * @return string
     * @throws InvalidStatusCodeException
     */
    public function createFromUrl(string $url, array $options = []): string
    {
        $response = $this->client->request(
            'POST',
            'v1/image',
            [
                RequestOptions::JSON => array_merge(['url' => $url], $options)
            ]
        );

        if ($response->getStatusCode() !== 200) {
            throw InvalidStatusCodeException::create(200, $response->getStatusCode(), (string)$response->getBody());
        }

        $body = json_decode($response->getBody()->getContents(), true);

        return $body['url'];
    }

    /**
     * @param string $html
     * @param string $css
     * @param array $options
     * @return string
     * @throws InvalidStatusCodeException
     */
    public function createFromHtml(string $html, string $css, array $options = []): string
    {
        $response = $this->client->request(
            'POST',
            'v1/image',
            [
                RequestOptions::JSON => array_merge(['html' => $html, 'css' => $css], $options)
            ]
        );

        if ($response->getStatusCode() !== 200) {
            throw InvalidStatusCodeException::create(200, $response->getStatusCode(), (string)$response->getBody());
        }

        $body = json_decode($response->getBody()->getContents(), true);

        return $body['url'];
    }

    /**
     * @param string $imageId
     * @return bool
     * @throws InvalidStatusCodeException
     */
    public function deleteImage(string $imageId): bool
    {
        $response = $this->client->request(
            'DELETE',
            'v1/image/' . $imageId
        );

        if ($response->getStatusCode() !== 202) {
            throw InvalidStatusCodeException::create(202, $response->getStatusCode(), (string)$response->getBody());
        }

        return true;
    }
}