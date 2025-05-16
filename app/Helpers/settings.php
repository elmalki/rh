<?php
use App\Models\Setting;

function setting($key, $default = null) {
    return optional(Setting::where('key', $key)->first())->value ?? $default;
}
