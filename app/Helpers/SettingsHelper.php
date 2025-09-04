<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Cache;

class SettingsHelper
{
    /**
     * Get a setting value from cache with fallback to default
     */
    public static function get($key, $default = null)
    {
        return Cache::get($key, $default);
    }
    
    /**
     * Set a setting value in cache
     */
    public static function set($key, $value, $ttl = null)
    {
        $ttl = $ttl ?? now()->addYears(1);
        return Cache::put($key, $value, $ttl);
    }
    
    /**
     * Get all settings as array
     */
    public static function all()
    {
        return [
            'site_name' => self::get('site_name', 'Kantor Camat Waesama'),
            'site_description' => self::get('site_description', 'Sistem Informasi Kantor Camat Waesama'),
            'contact_email' => self::get('contact_email', 'info@kecamatangwaesama.id'),
            'contact_phone' => self::get('contact_phone', '(0123) 456-7890'),
            'office_address' => self::get('office_address', 'Jl. Raya Waesama No. 123, Waesama'),
            'office_hours' => self::get('office_hours', 'Senin - Jumat: 08:00 - 16:00'),
            'max_queue_per_day' => self::get('max_queue_per_day', 50),
            'auto_approve_letters' => self::get('auto_approve_letters', false),
            'notification_email' => self::get('notification_email', true),
            'maintenance_mode' => self::get('maintenance_mode', false),
        ];
    }
    
    /**
     * Update multiple settings at once
     */
    public static function updateMultiple(array $settings)
    {
        foreach ($settings as $key => $value) {
            self::set($key, $value);
        }
        
        return true;
    }
    
    /**
     * Clear all settings from cache
     */
    public static function clearAll()
    {
        $keys = array_keys(self::all());
        foreach ($keys as $key) {
            Cache::forget($key);
        }
        
        return true;
    }
}