<?php

use App\Models\Setting;
use Illuminate\Support\Facades\Auth;

// if (!function_exists('getRoles')) {
//     function getRoles()
//     {
//         return Auth::user()->roles->pluck('name');
//     }
// }

// if (!function_exists('getPermissions')) {
//     function getPermissions()
//     {
//         return Auth::user()->permissions->pluck('name');
//     }
// }

if (!function_exists('isCompletedInfo')) {
    function isCompletedInfo()
    {
        $info = Auth::user()->additionalinformation;
        if ($info && !empty($info->job) && !empty($info->economic_unit) && !empty($info->ceo_name)) {
            return true;
        }
        return false;
    }
}

if (!function_exists('get_setting')) {
    function get_setting($key)
    {
        if ($setting = Setting::where('key', $key)->first()) {
            return $setting->value;
        }

        return false;
    }
}

if (!function_exists('get_settings')) {
    function get_settings()
    {
        if ($setting = Setting::all()) {
            return $setting;
        }
    }
}

if (!function_exists('insert_setting')) {
    function insert_setting($key, $value)
    {
        $setting = new Setting();
        $setting->key = $key;
        $setting->value = $value;
        if ($setting->save()) {
            return true;
        }
    }
}

if (!function_exists('update_setting')) {
    function update_setting($key, $value)
    {
        if ($setting = Setting::where('key', $key)->first()) {
            $setting->value = $value;
        } else {
            $setting = new Setting();
            $setting->key = $key;
            $setting->value = $value;
        }
        if ($setting->save()) {
            return true;
        }
    }
}

if (!function_exists('get_setting_collection')) {
    function get_setting_collection($settings, $key)
    {
        if ($option = $settings->where('key', $key)->first()) {
            return $option->value;
        }

        return false;
    }
}