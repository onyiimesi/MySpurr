<?php

namespace App\Services\Anchor;

use App\Models\V1\TalentCustomerLog;
use App\Services\Log\CreateCustomerLog;
use Illuminate\Support\Facades\Http;

class CreateCustomer {

    public $id;
    public $data;
    public $request;

    public function __construct($id, $data, $request)
    {
        $this->id = $id;
        $this->data = $data;
        $this->request = $request;
    }

    public function run()
    {
        $number = rand(00000000000, 99999999999);
        try {
            $response = Http::withHeaders([
                'accept' => 'application/json',
                'content-type' => 'application/json',
                'x-anchor-key' => env('ANCHOR_TEST_KEY'),
            ])
            ->post('https://api.sandbox.getanchor.co/api/v1/customers', [
                'data' => [
                    'attributes' => [
                        'fullName' => [
                            'firstName' => $this->data->first_name,
                            'lastName' => $this->data->last_name
                        ],
                        'address' => [
                            'country' => 'NG',
                            'state' => 'LAGOS',
                            'addressLine_1' => 'Lagos',
                            'city' => 'Lekki',
                            'postalCode' => '101223',
                        ],
                        'email' => $this->data->email,
                        'phoneNumber' => $number,
                    ],
                    'type' => 'IndividualCustomer',
                ]
            ]);

            $res = json_decode($response->body());
            $this->StoreLog($res);
            return json_decode($response->body());
        } catch (\Exception $exception) {
            $res = $exception->getMessage();
            $this->StoreLog($res);
            return $exception->getMessage();
        }
    }

    /**
     * @param $response
     * @param $status
     * @return TalentCustomerLog
    */
    protected function StoreLog($response): TalentCustomerLog
    {
        return (new CreateCustomerLog($this->id, $response, $response, $this->request))->run();
    }
}
