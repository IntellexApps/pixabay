<?php /** @noinspection PhpUnhandledExceptionInspection */
require '../vendor/autoload.php';

use Intellex\Pixabay\ImageAPI;
use Intellex\Pixabay\SearchParams;

require 'bootstrap.inc.php';

// Invoke the API
$api = new ImageAPI(API_KEY);
$response = $api->fetch(new SearchParams([ 'category' => 'travel', 'per_page' => 3, 'editors_choice' => true ]));

// Download and store
foreach($response->hits as $image) {
	$preview = explode('/', $image->previewURL);
	$name = end($preview);
	\Intellex\Pixabay\Downloader::downloadTo("/home/sabo/Pictures/pixabay/{$name}", $image->getURLForSize960());
}
