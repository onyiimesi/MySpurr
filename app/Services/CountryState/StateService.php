<?php

namespace App\Services\CountryState;


class StateService {

    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function run()
    {
        $url = env('COUNTRY_URL') . '/' . $this->data . '/states';
        $api_key = env('COUNTRY_STATE_CITY_API_KEY');

        $headers = array(
            "X-CSCAPI-KEY: " . $api_key
        );
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => $headers,
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);
        if ($err) {
            return "cURL Error #:" . $err;
        } else {
            return json_decode($response);
        }
    }
}
































