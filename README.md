# PHP client for Pixabay API

PHP client for Pixabay free image service.

* Support for the complete Pixabay API
* Both image and video
* Helper class for downloading the content

For more info check out the [official Pixabay API docs](https://pixabay.com/api/docs/).

##### Example

Images:

<pre>
// Invoke the API
$response = (new ImageAPI(API_KEY))->fetch(
	(new SearchParams())
		->setPerPage(5)
		->setEditorsChoice(true)
		->setCategory(Category::NATURE)
);

// Get over each image
foreach ($response->hits as $image) {

	// Show the image
	$src = $image->getURLForSize180();
	echo "&lt;img src=\"{$src}\" /&gt;";
	
	// Download to a local directory
	$preview = explode('/', $image->previewURL);
	$name = end($preview);
	Downloader::downloadTo("/home/pixabay/Download/{$name}", $image->getURLForSize960());
}
</pre>

Videos:

<pre>
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
	echo "&lt;img src=\"{$src}\" alt=\"\" /&gt;";
	echo "&lt;video width=\"1000\" height=\"800\" controls&gt;&lt;source src=\"{$video->largeVideo->url}\" type=\"video/mp4\"&gt;&lt;/video&gt;";
}
</pre>
TODO
--------------------
1. Multiple values for colors of image.

Licence
--------------------
MIT License

Copyright (c) 2019 Intellex

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.

Credits
--------------------
Script has been written by the [Intellex](https://intellex.rs/en) team.
