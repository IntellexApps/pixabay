<?php namespace Intellex\Pixabay;

use Intellex\Pixabay\Data\Page;
use Intellex\Pixabay\Exception\InvalidAPIKeyException;
use Intellex\Pixabay\Exception\TooManyRequestsException;
use Intellex\Pixabay\Exception\UnexpectedPixabayException;
use Intellex\Pixabay\Exception\UnsupportedSearchParameterException;
use Intellex\Pixabay\Validation\ValidationException;

/**
 * Class ApiAbstract is a base for all Pixabay API calls.
 *
 * @package Intellex\Pixabay
 */
abstract class ApiAbstract {

	/** @const string The endpoint which is targeted. */
	const ENDPOINT = 'https://pixabay.com/api/';

	/** @var string The API key used to identify on Pixabay. */
	private $apiKey;

	/**
	 * Initialize the search.
	 *
	 * @param string The API key used to identify on Pixabay.
	 */
	public function __construct($apiKey) {
		$this->apiKey = $apiKey;
	}

	/**
	 * Fetch from the API.
	 *
	 * @param SearchParams|array|null $params The list of GET params to use.
	 *
	 * @return Page The full response from the server.
	 * @throws TooManyRequestsException
	 * @throws ValidationException
	 * @throws InvalidAPIKeyException
	 * @throws UnexpectedPixabayException
	 * @throws UnsupportedSearchParameterException
	 */
	public function fetch($params = null) {

		// Set the url
		$url = static::ENDPOINT . $this->apiPrefix();

		// Default parameters
		if ($params === null) {
			$params = new SearchParams();
		}

		// Make sure the parameters are sent as object
		if (is_array($params)) {
			$params = new SearchParams($params);
		}

		// Execute
		$params = $this->modifyParams($params);
		list($httpResponseCode, $headers, $body) = $this->execute($url, $params);

		// Extract headers
		$parsedHeaders = [];
		foreach ($headers as $header) {
			if (strstr($header, ':')) {

				// Extract the name and the value of the header
				list($name, $value) = explode(':', $header);

				// Normalize the header name, ie: Content-Type
				$name = str_replace(' ', '-', ucwords(strtolower(str_replace('-', ' ', trim($name)))));

				$parsedHeaders[$name] = trim($value);
			}
		}

		// Check the response code
		switch ($httpResponseCode) {
			case 200:
			case 201:
				break;
			case 429:
				throw new TooManyRequestsException();
			default:
				if (strstr($body, 'API key')) {
					throw new InvalidAPIKeyException();
				} else {
					throw new UnexpectedPixabayException($body);
				}
		}

		// Return response
		$className = '\\Intellex\\Pixabay\\Data\\' . $this->usedPageClassName();
		return new $className(json_decode($body), $parsedHeaders);
	}

	/**
	 * Execute a CURL on an URL.
	 *
	 * @param string             $url        The url to read from.
	 * @param SearchParams|array $parameters The GET parameters for the request.
	 *
	 * @return array First element containing the HTTP response code, second the headers and third
	 *               the body of the response.
	 */
	private function execute($url, $parameters = []) {

		// Extract the parameters
		$params = $parameters->jsonSerialize();
		foreach ($params as $key => $value) {
			if (is_bool($value)) {
				$params[$key] = $value ? 'true' : 'false';
			}
		}

		// Set the options
		$params['key'] = $this->apiKey;
		$options = [
			CURLOPT_HEADER         => 1,
			CURLOPT_URL            => $url . '?' . http_build_query($params),
			CURLOPT_FRESH_CONNECT  => 1,
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_FORBID_REUSE   => 1,
			CURLOPT_TIMEOUT        => 4
		];

		// Initialize
		$curl = curl_init();
		curl_setopt_array($curl, $options);

		// Load
		list($headerBlock, $body) = preg_split('~\r?\n\r?\n~', curl_exec($curl), 2);
		$httpResponseCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
		curl_close($curl);

		// Split headers
		$headers = [];
		foreach (preg_split("~\r\n?~", $headerBlock) as $i => $header) {

			// Skip the first headers containing the HTTP response code
			if ($i) {
				list($key, $value) = explode(':', $header);
				$headers[trim($key)] = trim($value);
			}
		}

		return [ $httpResponseCode, $headers, $body ];
	}

	/**
	 * Defines a prefix used for creating a final URL.
	 *
	 * @return string The prefix to append to
	 */
	abstract protected function apiPrefix();

	/**
	 * Additionally modify the parameters.
	 *
	 * @param SearchParams $params The current parameters.
	 *
	 * @return SearchParams The modified list of parameters.
	 */
	abstract protected function modifyParams($params);

	/**
	 * Define the data structure that will be populate from the API.
	 *
	 * @return string The class name, without namespace prefix.
	 */
	abstract protected function usedPageClassName();

}
