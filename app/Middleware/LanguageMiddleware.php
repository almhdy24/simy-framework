<?php

namespace Almhdy\Simy\Middleware;

use Almhdy\Simy\Core\Translation\Translation;
use Almhdy\Simy\Core\Request;
use Almhdy\Simy\Core\Config;

class LanguageMiddleware extends BaseMiddleware
{
  public function handle()
  {
    // Get language from query parameter, default to config setting
    $language = (new Request())->get("lang");

    // Validate and set language
    if (in_array($language, ["en", "es"])) {
      // Add other supported languages here
      Translation::setLanguage($language);
    } else {
      Translation::setLanguage(Config::DEFAULT_LANGUAGE);
    }
  }
}
