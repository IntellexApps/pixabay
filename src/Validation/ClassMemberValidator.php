<?php namespace Intellex\Pixabay\Validation;

/**
 * Class ClassMemberValidator helps validate elements of an object.
 *
 * @package Intellex\Pixabay\Validation
 */
abstract class ClassMemberValidator {

	/**
	 * Validate a complete object.
	 *
	 * @param \stdClass $object An object to validate.
	 * @param array     $rules  The list of rules to test against.
	 *
	 * @throws ValidationException on first invalid field.
	 */
	public static function validate($object, $rules) {

		// Iterate over each member
		foreach ($rules as $member => $test) {
			static::assert($object, $member, $test);
		}
	}

	/**
	 * Assert that a value meet the rules.
	 *
	 * @param \Object|string  $object The object that is being tested, or string to simply name the
	 *                                variable.
	 * @param mixed           $member The name of the member to test, or the variable to test if
	 *                                $object is set to null.
	 * @param string|string[] $rules  The list of rules, as an array or comma separated string.
	 *
	 * @throws ValidationException if .
	 */
	public static function assert($object, $member, $rules) {

		// There might be multiple rules
		$rules = (array) $rules;
		foreach ($rules as $rule) {

			// Extract the parameters
			$params = '';
			if (strstr($rule, ':')) {
				list($rule, $params) = explode(':', $rule, 2);
			}

			// Test the value with the selected method
			$method = static::getMethod($rule);

			// Object
			$value = is_object($object) ? $object->$member : $member;
			$name = is_object($object) ? $member : $object;
			if ($error = static::$method($value, (array) explode(',', $params))) {
				throw new ValidationException($name, $value, $error);
			}
		}
	}

	/**
	 * Get method for the supplied rule.
	 *
	 * @param string $name The name of the rule.
	 *
	 * @return string The name of the method to use, or null if method is not found.
	 */
	private static function getMethod($name) {
		$method = '_' . $name;
		return method_exists(get_called_class(), $method) ? $method : null;
	}

	/**
	 * Extract the first two parameters.
	 *
	 * @param array $params Extract the first and the second parameter from the parameters.
	 *
	 * @return array The first item and the second item. Either (or both) can be null if not
	 *               specified.
	 */
	private static function extractRange($params) {
		return [
			key_exists(0, $params) && $params[0] !== null && $params[0] !== '' ? $params[0] : null,
			key_exists(1, $params) && $params[1] !== null && $params[1] !== '' ? $params[1] : null
		];
	}

	// @formatter:off

	// Empty

	public static function _required           ($val) { return is_null($val) || trim($val) === "" ? null : 'Value is required'; }
	public static function _notEmpty           ($val) { return !empty($val)                       ? null : 'Cannot be empty'; }
	public static function _notNull            ($val) { return !is_null($val)                     ? null : 'Cannot be null'; }
	public static function _notZero            ($val) { return $val !== 0 && $val !== "0"         ? null : 'Cannot be zero'; }

	// Boolean

	public static function _boolean            ($val) { return is_bool($val)                       ? null : 'Must be a boolean'; }

	// Integer

	public static function _positiveInteger    ($val) { static::_integer($val, [1]); }
	public static function _nonNegativeInteger ($val) { static::_integer($val, [0]); }
	public static function _negativeInteger    ($val) { static::_integer($val, [null,-1]); }
	public static function _nonPositiveInteger ($val) { static::_integer($val, [null, 0]); }
	public static function _integer            ($val, $params = []) {
		$message = 'Must be an integer';

		// Range
		list($min, $max) = static::extractRange($params);
		$rangeErrors = array_filter([
			$min !== null ? ">= {$min}" : null,
			$max !== null ? "<= {$max}" : null
		]);
		$message .= $rangeErrors ? ', ' . implode(' and ', $rangeErrors) : null;

		return is_int($val) && (!$min || $val >= $min) && (!$max || $val <= $max) ? null : $message;
	}

	// Float or double

	public static function _positiveFloat    ($val) { static::_float($val, [1]); }
	public static function _nonNegativeFloat ($val) { static::_float($val, [0]); }
	public static function _negativeFloat    ($val) { static::_float($val, [null,-1]); }
	public static function _nonPositiveFloat ($val) { static::_float($val, [null, 0]); }
	public static function _float            ($val, $params = []) {
		$message = 'Must be a float or a double';

		// Range
		list($min, $max) = static::extractRange($params);
		$rangeErrors = array_filter([
			$min !== null ? ">= {$min}" : null,
			$max !== null ? "<= {$max}" : null
		]);
		$message .= $rangeErrors ? ', that is ' . implode(' and ', $rangeErrors) : null;

		return (is_float($val) || is_double($val)) && (!$min || $val >= $min) && (!$max || $val <= $max) ? null : $message;
	}

	// String

	public static function _string             ($val) { return is_string($val) ? null : 'Must be a string'; }
	public static function _nonEmptyString     ($val) { return static::_string($val) && !empty(trim($val)) ? null : 'Must be a non-empty string';}

	// Array

	public static function _array              ($val) { return is_array($val) ? null : 'Must be an array'; }
	public static function _nonEmptyArray      ($val) { return static::_array($val) && sizeof($val) > 0 ? null : 'Must be a non-empty array'; }

	// Set

	public static function _set				   ($val, $params) { return in_array($val, $params) ?  null : 'Must be one of the following: [' . implode(', ', $params) . ']'; }

	// @formatter:on

}
