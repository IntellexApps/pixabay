<?php /** @noinspection PhpUnhandledExceptionInspection */
require '../vendor/autoload.php';

use Intellex\Pixabay\Enum\Category;
use Intellex\Pixabay\ImageAPI;
use Intellex\Pixabay\SearchParams;

require 'bootstrap.inc.php';

// Invoke the API
$response = (new ImageAPI(API_KEY))->fetch(
	(new SearchParams())
		->setPerPage(5)
		->setEditorsChoice(true)
		->setCategory(Category::NATURE)
);

// Show images
foreach ($response->hits as $image) {
	$src = $image->getURLForSize180();
	echo "<p><img src=\"{$src}\" alt=\"\" /></p>";
}
