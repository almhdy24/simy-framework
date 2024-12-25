<?php

namespace Almhdy\Simy\Core\Translation;

use Almhdy\Simy\Core\Config;

class Translation
{
    private static $language = Config::DEFAULT_LANGUAGE;
    private static $translations = [];

    /**
     * Set the language for translations
     *
     * @param string $language
     */
    public static function setLanguage(string $language): void
    {
        self::$language = $language;
        self::loadTranslations();
    }

    /**
     * Load translations from the JSON files
     */
    private static function loadTranslations(): void
    {
        $langDir = Config::BASE_DIR . '/app/Lang/' . self::$language;
        $filePath = $langDir . '/messages.json';

        if (file_exists($filePath)) {
            $translations = json_decode(file_get_contents($filePath), true);
            if (json_last_error() === JSON_ERROR_NONE) {
                self::$translations = $translations;
            }
        }
    }

    /**
     * Get a translated message
     *
     * @param string $key
     * @param array $placeholders
     * @return string
     */
    public static function get(string $key, array $placeholders = []): string
    {
        $message = self::$translations[$key] ?? $key;

        foreach ($placeholders as $placeholder => $value) {
            $message = str_replace("{{{$placeholder}}}", $value, $message);
        }

        return $message;
    }
}