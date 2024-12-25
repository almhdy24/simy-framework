<?php

namespace Almhdy\Simy\Core\Validation;

class CustomMessage
{
    public function getCustomErrorMessage(string $field, string $rule, array $params): string
    {
        // Define custom error messages for specific validation rules
        $messages = [
            "required" => "The $field field is required.",
            "email" => "Invalid email format for $field.",
            "numeric" => "The $field field must be a number.",
            "alpha" => "The $field field must contain only alphabetic characters.",
            "alphaNumeric" => "The $field field must be alphanumeric.",
            "min" => "The $field field must be at least {$params[1]} characters long.",
            "max" => "The $field field may not be greater than {$params[1]} characters.",
            "unique" => "The $field field must be unique.",
            "date" => "Invalid date format for $field.",
            "url" => "Invalid URL format for $field.",
            "string" => "The $field field must be a string.",
            "object" => "The $field field must be an object.",
            "array" => "The $field field must be an array.",
            "notNull" => "The $field field cannot be null.",
            "ipAddress" => "Invalid IP address format for $field.",
            "boolean" => "The $field field must be a boolean.",
        ];

        // Return the custom error message for the specific validation rule, or a default message
        return $messages[$rule] ?? "Validation failed for $field with rule $rule.";
    }
}