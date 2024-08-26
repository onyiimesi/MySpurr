<?php

use App\Models\V1\CountryTwo;
use App\Models\V1\State;
use Illuminate\Support\Facades\Cache;

if (!function_exists('get_countries')) {
    function get_countries() {
        return Cache::rememberForever('all_countries', function () {
            return CountryTwo::all();
        });
    }
}

if (!function_exists('get_states')) {
    function get_states() {
        return Cache::rememberForever('all_states', function () {
            return State::all();
        });
    }
}
