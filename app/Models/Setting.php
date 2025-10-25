<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class Setting extends Model
{
    protected $fillable = ['key', 'value'];

    /**
     * Get the value of a setting by key.
     * Safely returns $default if the settings table does not exist yet.
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public static function get($key, $default = null)
    {
        // If the settings table isn't present yet (fresh install / migrations not run),
        // avoid querying the DB early in the boot process and return the default.
        if (!Schema::hasTable('settings')) {
            return $default;
        }

        $setting = static::where('key', $key)->first();

        if ($setting) {
            $value = $setting->value;
            $decoded = json_decode($value, true);

            return json_last_error() === JSON_ERROR_NONE ? $decoded : $value;
        }

        return $default;
    }

    /**
     * Set the value of a setting by key.
     * If the settings table is not available, this is a no-op.
     *
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public static function set($key, $value)
    {
        if (!Schema::hasTable('settings')) {
            // migrations not run yet — silently skip to avoid crashing.
            return;
        }

        static::updateOrCreate(
            ['key' => $key],
            ['value' => is_array($value) || is_object($value) ? json_encode($value) : $value]
        );
    }
}