<?php namespace Intellex\Pixabay\Exception;

/**
 * Class TooManyRequestsException indicates that Pixabay has declined the request as the client
 * made too many requests (HTTP error 429).
 *
 * @see     https://pixabay.com/api/docs/#api_rate_limit.
 * @package Intellex\Pixabay\Exception
 */
class TooManyRequestsException extends PixabayException {
}
