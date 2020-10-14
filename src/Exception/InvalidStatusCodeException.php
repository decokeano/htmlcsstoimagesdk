<?php
declare(strict_types=1);

namespace CCT\Services\HtmlToImage\Exception;

use \Exception;

final class InvalidStatusCodeException extends Exception
{
    public static function create(int $expectedCode, int $actualCode, string $responseBody): self
    {
        return new self(
            sprintf('Expected "%d" but recieved "%d" with response body: %s', $expectedCode, $actualCode, $responseBody)
        );
    }
}