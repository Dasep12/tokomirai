<?php

use App\Models\Setting;

function setting($key)
{
    static $settings = null;

    if ($settings === null) {
        $settings = Setting::all()->keyBy('key');
    }

    return $settings[$key]->values ?? null;
}
