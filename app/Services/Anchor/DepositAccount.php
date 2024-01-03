<?php

namespace App\Services\Anchor;

use Illuminate\Support\Facades\Http;

class DepositAccount {

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
            ->post('https://api.sandbox.getanchor.co/api/v1/accounts', [
                'data' => [
                    'type' => 'DepositAccount',
                    'attributes' => [
                        'productName' => 'SAVINGS',
                    ],
                    'relationships' => [
                        'customer' => [
                            'data' => [
                                'id' => $this->data->data->id,
                                'type' => $this->data->data->type
                            ]
                        ]
                    ],
                    'type' => 'IndividualCustomer',
                ]
            ]);

            return $response->body();
        } catch (\Exception $exception) {
            return $exception->getMessage();
        }
    }
}
