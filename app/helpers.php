<?php

use App\Models\Translation;

if (!function_exists('trans_db')) {
    /**
     * Get translation from database
     *
     * @param string $key Translation key
     * @param array $replace Replacement values for placeholders
     * @param string|null $locale Locale code (defaults to current locale)
     * @param string $group Group name (defaults to 'public')
     * @return string
     */
    function trans_db(string $key, array $replace = [], ?string $locale = null, string $group = 'public'): string
    {
        $translation = Translation::get($key, $locale, $group);

        // Fallback to key if translation not found
        if (!$translation) {
            return $key;
        }

        // Replace placeholders
        foreach ($replace as $search => $value) {
            $translation = str_replace('{' . $search . '}', $value, $translation);
        }

        return $translation;
    }
}
