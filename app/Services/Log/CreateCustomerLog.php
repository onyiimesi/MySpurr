<?php

namespace App\Services\Log;

use App\Models\V1\TalentCustomerLog;

class CreateCustomerLog {

    public $user_id;
    public $res;
    public $response;
    public $request;

    public function __construct($user_id, $res, $response, $request)
    {
        $this->user_id = $user_id;
        $this->res = $res;
        $this->response = $response;
        $this->request = $request;
    }

    public function run ()
    {
        try {

            $log = new TalentCustomerLog();

            $log->talent_id = $this->user_id;
            $log->customer_id = $this->res->data->id;
            $log->type = $this->res->data->type;
            $log->createdAt = $this->res->data->attributes->createdAt;
            $log->phoneNumber = $this->res->data->attributes->phoneNumber;
            $log->email = $this->res->data->attributes->email;
            $log->organization_id = $this->res->data->relationships->organization->data->id;
            $log->request = json_encode($this->request);
            $log->response = json_encode($this->response);
            $log->status = $this->res->data->attributes->status;
            $log->save();

            return $log;

        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }
}



















































































