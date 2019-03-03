<?php namespace Intellex\Pixabay\Data;

use Intellex\Pixabay\DataAbstract;

/**
 * Class Image represents a single image data, as returned in the Pixabay API response.
 *
 * @package Intellex\Pixabay\Data
 */
class Image extends DataAbstract {

	/** @var int A unique identifier for updating expired image URLs. */
	public $id;

	/** @var string The type of the image. */
	public $type;

	/** @var string[] The list of tags. */
	public $tags;

	/** @var string Source page on Pixabay, which provides a download link for the original image of the dimension imageWidth x imageHeight and the file size imageSize. */
	public $pageURL;

	/** @var string Low resolution images with a maximum width or height of 150 px (previewWidth x previewHeight). */
	public $previewURL;

	/** @var int The width of the low resolution image. */
	public $previewWidth;

	/** @var int The height of the low resolution image. */
	public $previewHeight;

	/** @var string Medium sized image with a maximum width or height of 640 px (webformatWidth x webformatHeight). URL valid for 24 hours. */
	public $webformatURL;

	/** @var int The width of the web image. */
	public $webformatWidth;

	/** @var int The height of the web image. */
	public $webformatHeight;

	/** @var int Total number of views. */
	public $views;

	/** @var int Total number of downloads. */
	public $downloads;

	/** @var int Total number of favorites. */
	public $favorites;

	/** @var int Total number of likes. */
	public $likes;

	/** @var int Total number of comments. */
	public $comments;

	/** @var int User ID of the contributor. */
	public $user_id;

	/** @var string Name of the contributor. */
	public $user;

	/** @var string Profile picture URL (250 x 250 px). */
	public $userImageURL;

	/** @return array The validation rules. */
	protected function validationRules() {
		return [
			'id'              => 'nonNegativeInteger',
			'pageURL'         => 'string',
			'previewURL'      => 'string',
			'previewWidth'    => 'nonNegativeInteger',
			'previewHeight'   => 'nonNegativeInteger',
			'webformatURL'    => 'string',
			'webformatWidth'  => 'nonNegativeInteger',
			'webformatHeight' => 'nonNegativeInteger',
			'views'           => 'nonNegativeInteger',
			'downloads'       => 'nonNegativeInteger',
			'favorites'       => 'nonNegativeInteger',
			'likes'           => 'nonNegativeInteger',
			'comments'        => 'nonNegativeInteger',
			'user_id'         => 'nonNegativeInteger',
			'user'            => 'string',
			'userImageURL'    => 'string'
		];
	}

	/**
	 * Initialize the Image from JSON object.
	 *
	 * @param \stdClass The json to read the data from.
	 *
	 * @throws \Intellex\Pixabay\Validation\ValidationException if any of the validation fails.
	 */
	public function __construct($json) {
		$this->id = $json->id;
		$this->pageURL = $json->pageURL;
		$this->type = $json->type;
		$this->tags = preg_split('~\s*,\s*~', $json->tags);
		$this->previewURL = $json->previewURL;
		$this->previewWidth = $json->previewWidth;
		$this->previewHeight = $json->previewHeight;
		$this->webformatURL = $json->webformatURL;
		$this->webformatWidth = $json->webformatWidth;
		$this->webformatHeight = $json->webformatHeight;
		$this->views = $json->views;
		$this->downloads = $json->downloads;
		$this->favorites = $json->favorites;
		$this->likes = $json->likes;
		$this->comments = $json->comments;
		$this->user_id = $json->user_id;
		$this->user = $json->user;
		$this->userImageURL = $json->userImageURL;

		$this->validate();
	}

	/**
	 * Get the URL for the image with the maximum width or height limited to 180.
	 *
	 * @return string The URL to the requested size.
	 */
	public function getURLForSize180() {
		return $this->getURLForSize(180);
	}

	/**
	 * Get the URL for the image with the maximum width or height limited to 180.
	 *
	 * @return string The URL to the requested size.
	 */
	public function getURLForSize340() {
		return $this->getURLForSize(340);
	}

	/**
	 * Get the URL for the image with the maximum width or height limited to 180.
	 *
	 * @return string The URL to the requested size.
	 */
	public function getURLForSize640() {
		return $this->getURLForSize(640);
	}

	/**
	 * Get the URL for the image with the maximum width or height limited to 180.
	 *
	 * @return string The URL to the requested size.
	 */
	public function getURLForSize960() {
		return $this->getURLForSize(960);
	}

	/**
	 * Get the URL for the image with the maximum width or height limited to $size.
	 *
	 * @param int $size Maximum width or height of the image.
	 *
	 * @return string The URL to the requested size.
	 */
	private function getURLForSize($size) {
		return preg_replace('~_640(\.\w+)$~', "_{$size}\$1", $this->webformatURL);
	}

}
