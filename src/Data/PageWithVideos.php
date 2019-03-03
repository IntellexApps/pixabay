<?php namespace Intellex\Pixabay\Data;

/**
 * Class PageWithImages shows a page with videos.
 *
 * @package Intellex\Pixabay\Data
 */
class PageWithVideos extends Page {

	/** @var Video[] The array of all hits. */
	public $hits;

	/** @inheritdoc */
	public function getItemClass() {
		return 'Video';
	}

}
