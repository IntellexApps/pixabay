<?php namespace Intellex\Pixabay;

use Intellex\Pixabay\Validation\ClassMemberValidator;

/**
 * Class DataAbstract is the base for all data objects in the communication with the Pixabay.
 *
 * @package Intellex\Pixabay
 */
abstract class DataAbstract extends \stdClass {

	/**
	 * Define the validation rules.
	 *
	 * @return array The list of rules for validation;
	 */
	abstract protected function validationRules();

	/**
	 * Validate a complete object.
	 *
	 * @throws \Intellex\Pixabay\Validation\ValidationException if the validation fails.
	 */
	protected function validate() {
		ClassMemberValidator::validate($this, $this->validationRules());
	}

}
