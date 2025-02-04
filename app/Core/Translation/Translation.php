<?php

namespace Almhdy\Simy\Core\Translation;

use Almhdy\Simy\Core\Config;
use Almhdy\Simy\Core\Translation\TranslationException;

class Translation
{
  private static $language = Config::DEFAULT_LANGUAGE;
  private static $translations = [];
  private static $fallbackLanguage = "en"; // Default fallback language

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
   * Set the fallback language
   *
   * @param string $language
   */
  public static function setFallbackLanguage(string $language): void
  {
    self::$fallbackLanguage = $language;
  }

  /**
   * Load translations from the JSON files
   * @throws TranslationException
   */
  private static function loadTranslations(): void
  {
    $langDir = dirname(Config::BASE_DIR) . "/Lang/" . self::$language;
    $filePath = $langDir . "/messages.json";

    if (!file_exists($filePath)) {
      throw new TranslationException("Translation file not found: $filePath");
    }

    $translations = json_decode(file_get_contents($filePath), true);
    if (json_last_error() !== JSON_ERROR_NONE) {
      throw new TranslationException(
        "JSON decoding error in $filePath: " . json_last_error_msg()
      );
    }

    self::$translations = $translations;
  }

  /**
   * Load fallback translations
   * @throws TranslationException
   */
  private static function loadFallbackTranslations(): void
  {
    $fallbackLangDir =
      dirname(Config::BASE_DIR) . "Lang/" . self::$fallbackLanguage;
    $fallbackFilePath = $fallbackLangDir . "/messages.json";

    if (!file_exists($fallbackFilePath)) {
      throw new TranslationException(
        "Fallback translation file not found: $fallbackFilePath"
      );
    }

    $translations = json_decode(file_get_contents($fallbackFilePath), true);
    if (json_last_error() !== JSON_ERROR_NONE) {
      throw new TranslationException(
        "Fallback JSON decoding error in $fallbackFilePath: " .
          json_last_error_msg()
      );
    }

    self::$translations = $translations;
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
    $message = self::$translations[$key] ?? $key; // Fallback to key if not found

    foreach ($placeholders as $placeholder => $value) {
        $message = str_replace("{{{$placeholder}}}", $value, $message);
    }
    
    error_log("Final message: " . $message); // Log the final message
    
    return $message;
}

  /**
   * Check if a translation exists
   *
   * @param string $key
   * @return bool
   */
  public static function has(string $key): bool
  {
    return isset(self::$translations[$key]);
  }
}
