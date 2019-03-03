<?php /** @noinspection PhpUnhandledExceptionInspection */
require '../vendor/autoload.php';

use Intellex\Pixabay\Enum\Category;
use Intellex\Pixabay\SearchParams;
use Intellex\Pixabay\VideoAPI;

require 'bootstrap.inc.php';

// Invoke the API
$response = (new VideoAPI(API_KEY))->fetch(
	(new SearchParams())
		->setPerPage(3)
		->setEditorsChoice(true)
		->setCategory(Category::NATURE)
);

// Show videos
foreach ($response->hits as $video) {
	$src = $video->getPreviewImage295x166();
	echo "<img src=\"{$src}\" alt=\"\" />";
	echo "<video width=\"1000\" height=\"800\" controls><source src=\"{$video->largeVideo->url}\" type=\"video/mp4\"></video>";
	echo '<br /><br /><br /><br />';
}
