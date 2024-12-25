<?php

namespace Almhdy\Simy\Middleware;

use Almhdy\Simy\Core\Translation\Translation;
use Almhdy\Simy\Core\Config;

class LanguageMiddleware
{
    public function handle($request, $next)
    {
        // Get language from query parameter, default to config setting
        $language = $request->get('lang', Config::DEFAULT_LANGUAGE);
        
        // Validate and set language
        if (in_array($language, ['en', 'es'])) { // Add other supported languages here
            Translation::setLanguage($language);
        } else {
            Translation::setLanguage(Config::DEFAULT_LANGUAGE);
        }

        return $next($request);
    }
}