<?php

namespace App\Services\Others;

use App\Models\V1\Visitor;
use App\Traits\HttpResponses;
use GeoIp2\Database\Reader;

class Service
{
    use HttpResponses;

    public function postVisitors($request)
    {
        $ip = $request->ip();

        $existingVisitor = Visitor::where('ip_address', $ip)->first();

        if (!$existingVisitor) {
            $country = null;
            $user_agent = $request->header('User-Agent');

            if ($ip !== '127.0.0.1') {
                try {
                    $reader = new Reader(public_path('geo/GeoLite2-Country.mmdb'));
                    $record = $reader->country($ip);
                    $country = $record->country->name ?? null;
                } catch (\Exception $e) {
                    return $this->error(null, 500, $e->getMessage());
                }
            }

            Visitor::create([
                'ip_address' => $ip,
                'country' => $country,
                'user_agent' => $user_agent,
            ]);
        } else {
            $country = null;
            $user_agent = $request->header('User-Agent');

            if ($ip !== '127.0.0.1') {
                try {
                    $reader = new Reader(public_path('geo/GeoLite2-Country.mmdb'));
                    $record = $reader->country($ip);
                    $country = $record->country->name ?? null;
                } catch (\Exception $e) {
                    return $this->error(null, 500, $e->getMessage());
                }
            }

            $existingVisitor->update([
                'ip_address' => $ip,
                'country' => $country,
                'user_agent' => $user_agent,
            ]);
        }
    }
}






