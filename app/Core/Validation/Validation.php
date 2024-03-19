<?php
namespace Almhdy\Simy\Core\Validation;

/**
 * Class Validation
 *
 * A class for handling data validation tasks
 */
class Validation
{
	/**
	 * @var array $errors An array to store validation errors
	 */
	protected array $errors = [];

	/**
	 * Validate data based on specified rules
	 *
	 * @param array $data The data to be validated
	 * @param array $rules The rules for validation
	 * @param array $customMessages Custom error messages
	 * @return bool Returns true if data is valid, false otherwise
	 */
	public function validate(
		array $data,
		array $rules,
		array $customMessages = []
	): bool {
		foreach ($rules as $field => $rule) {
			$rulesArray = explode("|", $rule);
			foreach ($rulesArray as $singleRule) {
				$ruleParts = explode(":", $singleRule);
				$ruleName = $ruleParts[0];
				$params = $ruleParts[1] ?? ""; // PHP 8 null coalescing operator

				$valid = $this->validateRule($field, $data[$field], $ruleName, $params);

				if (!$valid) {
					$message =
						$customMessages[$field . "." . $ruleName] ??
						"The $field field is not valid.";
					$this->addError($field, $message);
				}
			}
		}

		return empty($this->errors);
	}

	/**
	 * Validate a single rule for a field
	 *
	 * @param string $field The field name
	 * @param mixed $value The value to be validated
	 * @param string $ruleName The name of the validation rule
	 * @param mixed $params Parameters for the validation rule
	 * @return bool Returns true if the rule is valid, false otherwise
	 */
	protected function validateRule(
		string $field,
		$value,
		string $ruleName,
		mixed $params
	): bool {
		switch ($ruleName) {
			case "required":
				return $this->validateRequired($value);
			case "email":
				return $this->validateEmail($value);
			case "numeric":
				return $this->validateNumeric($value);
			case "string":
				return $this->validateString($value);
			// Add more rule cases as needed
			default:
				return true;
		}
	}

	/**
	 * Validate if a value is required (not empty)
	 *
	 * @param mixed $value The value to be validated
	 * @return bool Returns true if the value is not empty, false otherwise
	 */
	protected function validateRequired(mixed $value): bool
	{
		return !empty($value);
	}

	/**
	 * Validate if a value is a valid email address
	 *
	 * @param string $value The value to be validated
	 * @return bool Returns true if the value is a valid email address, false otherwise
	 */
	protected function validateEmail(string $value): bool
	{
		return filter_var($value, FILTER_VALIDATE_EMAIL) !== false;
	}

	/**
	 * Validate if a value is numeric
	 *
	 * @param mixed $value The value to be validated
	 * @return bool Returns true if the value is numeric, false otherwise
	 */
	protected function validateNumeric(mixed $value): bool
	{
		return is_numeric($value);
	}

	/**
	 * Validate if a value is a string
	 *
	 * @param mixed $value The value to be validated
	 * @return bool Returns true if the value is a string, false otherwise
	 */
	protected function validateString(mixed $value): bool
	{
		return is_string($value);
	}

	/**
	 * Add an error message for a field
	 *
	 * @param string $field The field name
	 * @param string $message The error message
	 */
	protected function addError(string $field, string $message): void
	{
		$this->errors[$field] = $message;
	}

	/**
	 * Get all validation errors
	 *
	 * @return array Returns an array of validation errors
	 */
	public function getErrors(): array
	{
		return $this->errors;
	}
}
