<?php

use App\Models\V1\Country;
use App\Models\V1\CountryTwo;
use App\Models\V1\State;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

if (!function_exists('get_countries')) {
    function get_countries() {
        return CountryTwo::select('id', 'name', 'iso2', 'iso3')->get();
    }
}

if (!function_exists('get_states')) {
    function get_states() {
        return State::select('id', 'country_id', 'name', 'iso2')->get();
    }
}

if (!function_exists('sendMail')) {
    function sendMail($email, $action) {
        Mail::to($email)->send($action);
    }
}

if (!function_exists('logAction')) {
    function logAction() {
        Log::info('Log working!');
    }
}

if (!function_exists('getCountry')) {
    function getCountry() {
        return Cache::rememberForever('countries', function () {
            return Country::all();
        });
    }
}

