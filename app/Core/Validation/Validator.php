<?php

namespace Almhdy\Simy\Core\Validation;

use Almhdy\Simy\Core\Validation\ValidationRules;
use Almhdy\Simy\Core\Validation\CustomMessage;
use Almhdy\Simy\Core\Translation\Translation;

class Validator
{
    protected array $errors = [];
    protected ValidationRules $validationRules;
    protected CustomMessage $customMessages;
    protected array $customValidations = [];
    protected string $language;

    public function __construct(string $language = 'en')
    {
        $this->validationRules = new ValidationRules();
        $this->customMessages = new CustomMessage();
        $this->language = $language;
        Translation::setLanguage($this->language);
    }

    public function extend(string $ruleName, callable $callback): void
    {
        $this->customValidations[$ruleName] = $callback;
    }

    public function validate(array $data, array $rules): bool
    {
        $isValid = true;

        foreach ($rules as $field => $rule) {
            $ruleList = explode("|", $rule);
            $fieldValue = $data[$field] ?? null;
            $fieldErrors = [];

            foreach ($ruleList as $singleRule) {
                $params = explode(":", $singleRule);
                $ruleName = array_shift($params);
                $params = array_merge([$fieldValue], $params);

                if (method_exists(ValidationRules::class, $ruleName) ||
                    (isset($this->customValidations[$ruleName]) &&
                    is_callable($this->customValidations[$ruleName]))) {
                    $validationFunction = method_exists(ValidationRules::class, $ruleName)
                        ? [ValidationRules::class, $ruleName]
                        : $this->customValidations[$ruleName];

                    if (!call_user_func_array($validationFunction, $params)) {
                        $customErrorMessage = $this->customMessages->getCustomErrorMessage(
                            $field,
                            $ruleName,
                            $params,
                            $this->language
                        );
                        $fieldErrors[] = $customErrorMessage;
                        $isValid = false;
                    }
                } else {
                    $fieldErrors[] = Translation::get("validation_rule_not_found", ['field' => $field, 'rule' => $ruleName]);
                    $isValid = false;
                }
            }

            $this->addErrors($field, $fieldErrors);
        }

        return $isValid;
    }

    private function addErrors(string $field, array $newErrors): void
    {
        if (!empty($newErrors)) {
            if (isset($this->errors[$field])) {
                $this->errors[$field] = array_merge($this->errors[$field], $newErrors);
            } else {
                $this->errors[$field] = $newErrors;
            }
        }
    }

    public function passes(): bool
    {
        return empty($this->errors);
    }

    public function fails(): bool
    {
        return !$this->passes();
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}