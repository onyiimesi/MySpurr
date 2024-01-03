<?php

namespace App\Services\Anchor;

use Illuminate\Support\Facades\Http;

class KycValidation {

    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function run()
    {
        try {
            $response = Http::withHeaders([
                'accept' => 'application/json',
                'content-type' => 'application/json',
                'x-anchor-key' => env('ANCHOR_TEST_KEY'),
            ])
            ->post('https://api.sandbox.getanchor.co/api/v1/customers/'.$this->data->data->id.'/verification/individual', [
                'data' => [
                    'type' => 'Verification',
                    'attributes' => [
                        'level' => 'TIER_3',
                        'level2' => [
                            'bvn' => '',
                            'selfie' => '',
                            'dateOfBirth' => '',
                            'gender' => ''
                        ],
                        'level3' => [
                            'idNumber' => 'DL123456789',
                            'idType' => 'DriversLicense',
                            'expiryDate' => '1985-04-12'
                        ]
                    ]
                ]
            ]);

            return $response->body();
        } catch (\Exception $exception) {
            return $exception->getMessage();
        }
    }
}
