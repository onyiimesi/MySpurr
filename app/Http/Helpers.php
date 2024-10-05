<?php

use App\Models\V1\CountryTwo;
use App\Models\V1\State;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

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

