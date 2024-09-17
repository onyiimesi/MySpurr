<?php

namespace App\Services\Others;

class EmailSender
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function run()
    {
        $client = new \GuzzleHttp\Client();

        $json = [
        "email" => $this->data->email,
        "firstname" => $this->data->first_name,
        "lastname" => $this->data->last_name,
        "groups" => ["eZVD4w", "b2vAR1"],
        "fields" => ['{$test_text}' =>"Documentation example",'{$test_num}' => 8],
        "phone" => $this->data->phone_number,
        "trigger_automation" => false
        ];

        $client->post(
            config('services.email_sender_base_url'),
            [
                'headers' => [
                    'Authorization' => 'Bearer '.config('services.email_sender_token'),
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                ],
                'json' => $json
            ]
        );
        //$body = $response->getBody()->getContents();
        //$data = json_decode($body, true);
    }
}


