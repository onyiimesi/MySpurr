<?php

namespace App\Services\CountryState;


class StateDetailsService {

    public $ciso;
    public $siso;

    public function __construct($ciso, $siso)
    {
        $this->ciso = $ciso;
        $this->siso = $siso;
    }

    public function run()
    {
        $url = config('services.country_url') . '/' . $this->ciso . '/states/' . $this->siso;
        $api_key = config('services.country_city');

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
































