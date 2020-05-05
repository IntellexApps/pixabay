<?php /** @noinspection PhpUnhandledExceptionInspection */
require '../vendor/autoload.php';

use Intellex\Pixabay\Downloader;
use Intellex\Pixabay\ImageAPI;
use Intellex\Pixabay\SearchParams;

require 'bootstrap.inc.php';

// Invoke the API
$response = (new ImageAPI(API_KEY))->fetch(new SearchParams([
	SearchParams::CATEGORY       => \Intellex\Pixabay\Enum\Category::ANIMALS,
	SearchParams::PER_PAGE       => max(200, isset($argv[2]) ? $argv[2] : 200),
	SearchParams::SAFE_SEARCH    => true,
	SearchParams::EDITORS_CHOICE => true
]));

// Get destination
if ($argc > 1) {
	$destination = rtrim($argv[1], DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
} else {
	echo "Usage: php -f <destination> <count>";
}

// Download and store
$hits = $response->hits;
$count = sizeof($hits);
foreach ($hits as $i => $image) {
	$preview = explode('/', $image->previewURL);
	$name = end($preview) . PHP_EOL;
	echo sprintf("%3s / %3s, %s", $i + 1, $count, $name);
	Downloader::downloadTo($image->getLargeImage(), "~/Pictures/pixabay/{$name}");
}
