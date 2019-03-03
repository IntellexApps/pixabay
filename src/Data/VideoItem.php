<?php namespace Intellex\Pixabay\Data;

use Intellex\Pixabay\DataAbstract;

/**
 * Class VideoItem represents a single video format, in a specific resolution.
 *
 * @package Intellex\Pixabay\Data
 */
class VideoItem extends DataAbstract {

	/** @var string A path to the video it self. */
	public $url;

	/** @var int The width of the video. */
	public $width;

	/** @var int The height of the video. */
	public $height;

	/** @var int The size of the video, in bytes. */
	public $size;

	/** @return array The validation rules. */
	protected function validationRules() {
		return [
			'url'    => 'string',
			'width'  => 'positiveInteger',
			'height' => 'positiveInteger',
			'size'   => 'positiveInteger',
		];
	}

	/**
	 * Initialize the VideoItem from JSON object.
	 *
	 * @param \stdClass The json to read the data from.
	 *
	 * @throws \Intellex\Pixabay\Validation\ValidationException if any of the validation fails.
	 */
	public function __construct($json) {
		$this->url = $json->url;
		$this->width = $json->width;
		$this->height = $json->height;
		$this->size = $json->size;

		$this->validate();
	}

}