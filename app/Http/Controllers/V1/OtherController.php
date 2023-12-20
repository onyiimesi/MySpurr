<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Models\V1\Country;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;

class OtherController extends Controller
{
    use HttpResponses;

    public function country()
    {
        $country = Country::select('code', 'name')->get();
        return $this->success($country, "", 200);
    }
}
