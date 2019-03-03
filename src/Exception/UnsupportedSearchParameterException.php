<?php namespace Intellex\Pixabay\Exception;

/**
 * Class UnsupportedSearchParameterException indicates that a supplied parameter is not recognized.
 *
 * @package Intellex\Pixabay\Exception
 */
class UnsupportedSearchParameterException extends PixabayException {

	/**
	 * UnknownParametersException constructor.
	 *
	 * @param string $parameterName The parameter that is unsupported.
	 */
	public function __construct($parameterName) {
		parent::__construct("Unsupported search parameter supplied: {$parameterName}");
	}

}
