<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Translation extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'locale',
        'value',
        'group',
    ];

    /**
     * Get translation by key and locale
     */
    public static function get(string $key, ?string $locale = null, string $group = 'public'): ?string
    {
        $locale = $locale ?? app()->getLocale();

        $translation = static::where('key', $key)
            ->where('locale', $locale)
            ->where('group', $group)
            ->first();

        // Fallback to English if translation not found
        if (!$translation && $locale !== 'en') {
            $translation = static::where('key', $key)
                ->where('locale', 'en')
                ->where('group', $group)
                ->first();
        }

        return $translation?->value;
    }

    /**
     * Set or update translation
     */
    public static function set(string $key, string $value, string $locale, string $group = 'public'): self
    {
        return static::updateOrCreate(
            ['key' => $key, 'locale' => $locale, 'group' => $group],
            ['value' => $value]
        );
    }
}
