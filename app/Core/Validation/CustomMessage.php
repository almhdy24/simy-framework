<?php

namespace Almhdy\Simy\Core\Validation;

use Almhdy\Simy\Core\Translation\Translation;

class CustomMessage
{
    protected $translator;

    public function __construct()
    {
        $this->translator = new Translation();
    }

    public function getCustomErrorMessage(string $field, string $rule, array $params, string $lang = 'en'): string
    {
        Translation::setLanguage($lang);
        $translationParams = array_merge(['field' => $field], $params);
        return Translation::get($rule, $translationParams);
    }
}