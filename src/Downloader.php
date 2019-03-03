<?php namespace Intellex\Pixabay;

/**
 * Class Downloader downloads a remote file.
 *
 * @package Intellex\Pixabay
 */
abstract class Downloader {

	/**
	 * Download the file from the net..
	 *
	 * @param string $url The URL of the remote file.
	 *
	 * @return string The binary of the downloaded file.
	 */
	public static function download($url) {
		return file_get_contents($url);
	}

	/**
	 * Download the file from the net and store it to a file on the local filesystem.
	 *
	 * @param string $url  The URL of the remote file.
	 * @param string $path path to the local file.
	 */
	public static function downloadTo($url, $path) {
		file_put_contents($path, static::download($url));
	}

}
