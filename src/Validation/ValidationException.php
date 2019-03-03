<?php namespace Intellex\Pixabay\Validation;

/**
 * Class ValidationException Indicates that the validation has failed.
 *
 * @package Intellex\Pixabay\Validation
 */
class ValidationException extends \Exception {

	/** @var string The name of the class which produces the validation error. */
	public $className;

	/** @var string The class member which produced the error. */
	public $member;

	/** @var mixed The value which produced the error. */
	public $value;

	/** @var string Human friendly validation error message. */
	public $message;

	/**
	 * Initialize exception.
	 *
	 * @param string $name    The name of the variable that failed.
	 * @param string $value   The value which produced the error.
	 * @param string $message Human friendly validation error message.
	 */
	public function __construct($name, $value, $message) {

		// Additional information about the value
		ob_start();
		print_r($value);
		$value = ob_get_clean();

		parent::__construct("Value of {$name} cannot have a value of {$value}: {$message}.");
	}

	/**
	 * @return string The name of the class which produces the validation error.
	 */
	public function getClassName() {
		return $this->className;
	}

	/**
	 * @return string The class member which produced the error.
	 */
	public function getMember() {
		return $this->member;
	}

	/**
	 * @return string The value which produced the error.
	 */
	public function value() {
		return $this->value;
	}

	/**
	 * @return string Human friendly validation error message.
	 */
	public function getValidationError() {
		return $this->message;
	}

}
