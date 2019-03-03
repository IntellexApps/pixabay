<?php namespace Intellex\Pixabay\Data;

use Intellex\Pixabay\DataAbstract;
use Intellex\Pixabay\Enum\VideoPreviewSize;

/**
 * Class Video represents a single video data, as returned in the Pixabay API response.
 *
 * @package Intellex\Pixabay\Data
 */
class Video extends DataAbstract {

	/** @var int A unique identifier for updating expired image URLs. */
	public $id;

	/** @var string The type of the image. */
	public $type;

	/** @var string[] The list of tags. */
	public $tags;

	/** @var string Source page on Pixabay, which provides a download link for the original image of the dimension imageWidth x imageHeight and the file size imageSize. */
	public $pageURL;

	/** @var int The duration of the video, in seconds. */
	public $duration;

	/** @var string Value used to retrieve static preview images of the video in various sizes. */
	public $pictureId;

	/** @var VideoItem|null The video in the largest resolution (typically has a dimension of 1920x1080), which is not always available (null it that case). */
	public $largeVideo;

	/** @var VideoItem The video in medium resolution (typically has a dimension of 1280x720). */
	public $mediumVideo;

	/** @var VideoItem The video in small resolution (typically has a dimension of 960x540, or 640x360 for older videos). */
	public $smallVideo;

	/** @var VideoItem The video in tiny resolution (typically has a dimension of 640x360, or 480x270 for older videos). */
	public $tinyVideo;

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
			'id'           => 'nonNegativeInteger',
			'pageURL'      => 'string',
			'type'         => 'string',
			'tags'         => 'array',
			'duration'     => 'nonNegativeInteger',
			'pictureId'    => 'string',
			'views'        => 'nonNegativeInteger',
			'downloads'    => 'nonNegativeInteger',
			'favorites'    => 'nonNegativeInteger',
			'likes'        => 'nonNegativeInteger',
			'comments'     => 'nonNegativeInteger',
			'user_id'      => 'nonNegativeInteger',
			'user'         => 'string',
			'userImageURL' => 'string'
		];
	}

	/**
	 * Initialize the Video from JSON object.
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
		$this->duration = $json->duration;
		$this->pictureId = $json->picture_id;
		$this->views = $json->views;
		$this->downloads = $json->downloads;
		$this->favorites = $json->favorites;
		$this->likes = $json->likes;
		$this->comments = $json->comments;
		$this->user_id = $json->user_id;
		$this->user = $json->user;
		$this->userImageURL = $json->userImageURL;

		// Load each video resolution
		$this->largeVideo = property_exists($json->videos, 'large') && $json->videos->large !== null
			? new VideoItem($json->videos->large)
			: null;
		$this->mediumVideo = new VideoItem($json->videos->medium);
		$this->smallVideo = new VideoItem($json->videos->small);
		$this->tinyVideo = new VideoItem($json->videos->tiny);

		$this->validate();
	}

	/**
	 * Get the URL for the video preview image.
	 *
	 * @return string The URL to the requested preview in full HD (1920x1080).
	 */
	public function getPreviewImageFullHD() {
		return $this->getPreviewImage(VideoPreviewSize::_1920x1080);
	}

	/**
	 * Get the URL for the video preview image.
	 *
	 * @return string The URL to the requested preview in 960x540.
	 */
	public function getPreviewImage960x540() {
		return $this->getPreviewImage(VideoPreviewSize::_960x540);
	}

	/**
	 * Get the URL for the video preview image.
	 *
	 * @return string The URL to the requested preview in 640x360.
	 */
	public function getPreviewImage640x360() {
		return $this->getPreviewImage(VideoPreviewSize::_640x360);
	}

	/**
	 * Get the URL for the video preview image.
	 *
	 * @return string The URL to the requested preview in 295x166.
	 */
	public function getPreviewImage295x166() {
		return $this->getPreviewImage(VideoPreviewSize::_295x166);
	}

	/**
	 * Get the URL for the video preview image.
	 *
	 * @return string The URL to the requested preview in 200x150.
	 */
	public function getPreviewImage200x150() {
		return $this->getPreviewImage(VideoPreviewSize::_200x150);
	}

	/**
	 * Get the URL for the video preview image.
	 *
	 * @return string The URL to the requested preview in 100x75.
	 */
	public function getPreviewImage100x75() {
		return $this->getPreviewImage(VideoPreviewSize::_100x75);
	}

	/**
	 * Get the URL for the video preview image.
	 *
	 * @param string $size The size for the preview, @see VideoPreviewSize.
	 *
	 * @return string The URL to the requested preview.
	 */
	private function getPreviewImage($size) {
		return sprintf('https://i.vimeocdn.com/video/%s_%s.jpg', $this->pictureId, $size);
	}

}
