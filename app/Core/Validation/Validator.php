<?php
namespace Almhdy\Simy\Core\Validation;
use Almhdy\Simy\Core\Validation\ValidationRules;
use Almhdy\Simy\Core\Validation\CustomMessages;

class Validator
{
  protected $errors = [];
  protected $validationRules;
  protected $customMessages;
  protected $customValidations = [];

  public function __construct()
  {
    $this->validationRules = new ValidationRules();
    $this->customMessages = new CustomMessage();
  }

  public function extend($ruleName, callable $callback)
  {
    // Allow users to add custom validation rules
    $this->customValidations[$ruleName] = $callback;
  }

  public function validate($data, $rules): bool
  {
    $isValid = true;

    foreach ($rules as $field => $rule) {
      $ruleList = explode("|", $rule);
      $fieldValue = $data[$field];
      $fieldErrors = [];

      foreach ($ruleList as $singleRule) {
        $params = explode(":", $singleRule);
        $ruleName = array_shift($params);
        $params = array_merge([$fieldValue], $params);

        if (
          method_exists(ValidationRules::class, $ruleName) ||
          (isset($this->customValidations[$ruleName]) &&
            is_callable($this->customValidations[$ruleName]))
        ) {
          $validationFunction = method_exists(ValidationRules::class, $ruleName)
            ? [ValidationRules::class, $ruleName]
            : $this->customValidations[$ruleName];

          if (!call_user_func_array($validationFunction, $params)) {
            $customErrorMessage = $this->customMessages->getCustomErrorMessage(
              $field,
              $ruleName,
              $params
            );
            $fieldErrors[] = $customErrorMessage;
            $isValid = false;
          }
        } else {
          $fieldErrors[] = "Validation rule $ruleName not found for $field.";
          $isValid = false;
        }
      }

      $this->addErrors($field, $fieldErrors);
    }

    return $isValid;
  }


  private function addErrors($field, $newErrors)
  {
    if (!empty($newErrors)) {
      if (isset($this->errors[$field])) {
        $this->errors[$field] = array_merge($this->errors[$field], $newErrors);
      } else {
        $this->errors[$field] = $newErrors;
      }
    }
  }

  public function passes()
  {
    return empty($this->errors);
  }

  public function fails()
  {
    return !$this->passes();
  }

  public function getErrors()
  {
    return $this->errors;
  }
}
