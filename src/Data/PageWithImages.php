<?php namespace Intellex\Pixabay\Data;

/**
 * Class PageWithImages shows a page with images.
 *
 * @package Intellex\Pixabay\Data
 */
class PageWithImages extends Page {

	/** @var Image[] The array of all hits. */
	public $hits;

	/** @inheritdoc */
	public function getItemClass() {
		return 'Image';
	}

}
