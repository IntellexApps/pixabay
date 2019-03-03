<?php namespace Intellex\Pixabay\Data;

use Intellex\Pixabay\DataAbstract;

/**
 * Class Page represents a single page, as returned in the Pixabay API response.
 *
 * @package Intellex\Pixabay\Data
 */
abstract class Page extends DataAbstract {

	/** @var int The total number of hits. */
	public $total;

	/** @var int The number of images accessible through the API. By default, the API is limited to return a maximum of 500 images per query. */
	public $totalHits;

	/** @var array The array of all hits. */
	public $hits;

	/** @var string[] Additional headers in the response from the pixabay. */
	public $headers;

	/** @return array The validation rules. */
	protected function validationRules() {
		return [
			'total'     => 'nonNegativeInteger',
			'totalHits' => 'nonNegativeInteger',
			'hits'      => 'array'
		];
	}

	/**
	 * Initialize the Page from JSON object.
	 *
	 * @param mixed    $json    The json to read the data from.
	 * @param string[] $headers Additional headers in the response from the Pixabay.
	 *
	 * @throws \Intellex\Pixabay\Validation\ValidationException if any of the validation fails.
	 */
	public function __construct($json, $headers) {

		// Count
		$this->total = (int) $json->total;
		$this->totalHits = (int) $json->totalHits;

		// Set hits
		$className = '\\Intellex\\Pixabay\\Data\\' . $this->getItemClass();
		foreach ($json->hits as $hit) {
			$this->hits[] = new $className($hit);
		}

		// Load headers
		$this->headers = $headers;

		$this->validate();
	}

	/**
	 * Define the class name that will be used for the hits.
	 *
	 * @return string The name fof the class used, without the namespace prefix.
	 */
	abstract public function getItemClass();

}
