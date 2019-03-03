<?php namespace Intellex\Pixabay;

use Intellex\Pixabay\Data\PageWithVideos;
use Intellex\Pixabay\Exception\InvalidAPIKeyException;
use Intellex\Pixabay\Exception\TooManyRequestsException;
use Intellex\Pixabay\Exception\UnexpectedPixabayException;
use Intellex\Pixabay\Exception\UnsupportedSearchParameterException;
use Intellex\Pixabay\Validation\ValidationException;

/**
 * Class VideoAPI executes the search search on the video API.
 *
 * @package Intellex\Pixabay
 */
class VideoAPI extends ApiAbstract {

	/**
	 * Defines a prefix used for creating a final URL.
	 *
	 * @return string The prefix to append to
	 */
	protected function apiPrefix() {
		return 'videos/';
	}

	/**
	 * Additionally modify the parameters.
	 *
	 * @param SearchParams $params The current parameters.
	 *
	 * @return SearchParams The modified list of parameters.
	 */
	protected function modifyParams($params) {
		return $params;
	}

	/**
	 * Define the data structure that will be populate from the API.
	 *
	 * @return string The class name, without namespace prefix.
	 */
	protected function usedPageClassName() {
		return 'PageWithVideos';
	}

	/**
	 * Fetch from the API.
	 *
	 * @param SearchParams|array $params The list of GET params to use.
	 *
	 * @return PageWithVideos The full response from the server.
	 * @throws TooManyRequestsException
	 * @throws ValidationException
	 * @throws InvalidAPIKeyException
	 * @throws UnexpectedPixabayException
	 * @throws UnsupportedSearchParameterException
	 */
	public function fetch($params = []) {
		/** @noinspection PhpIncompatibleReturnTypeInspection */
		return parent::fetch($params);
	}

}
