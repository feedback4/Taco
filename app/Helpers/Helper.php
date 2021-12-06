<?php


if (!function_exists('setting')) {
    function setting($key)
    {

        $setting = \Illuminate\Support\Facades\Cache::rememberForever('setting-'.$key, function () use($key) {
            return \App\Models\Setting::where('name',$key)->first();
        });

       // $setting = \App\Models\Setting::where('name',$key)->first();

        if (!$setting) {
            return;
        }
        return $setting->value;
    }
}

if (!function_exists('settingVal')) {
    function settingVal($key)
    {
        $setting = [
            'working_days' => [
                7
            ],
        ];
    }
}



