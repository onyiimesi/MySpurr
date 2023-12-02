<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Models\V1\Talent;
use App\Models\V1\TalentLanguage;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    use HttpResponses;

    public function accounts(Request $request, $id)
    {
        $user = Talent::where('id', $id)->first();
        if(!$user){
            return $this->error('', 404, 'User not found');
        }

        $user->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'location' => $request->location,
            'currency' => $request->currency,
            'application_link' => $request->application_link,
            'country_code' => $request->country_code,
            'phone_number' => $request->phone_number,
        ]);

        $user->talentbillingaddress()->create([
            'country' => $request->billing_address['country'],
            'state' => $request->billing_address['state'],
            'address_1' => $request->billing_address['address_1'],
            'address_2' => $request->billing_address['address_2'],
            'city' => $request->billing_address['city'],
            'zip_code' => $request->billing_address['zip_code']
        ]);

        foreach ($request->language as $lang) {
            $langs = new TalentLanguage($lang);
            $user->talentlanguage()->save($langs);
        }

        return [
            "status" => 'true',
            "message" => 'Updated Successfully'
        ];
    }

    public function deleteaccount($id)
    {
        $user = Talent::where('id', $id)->first();
        if(!$user){
            return $this->error('', 404, 'User not found');
        }

        $user->delete();

        return [
            "status" => 'true',
            "message" => 'Account Deleted Successfully'
        ];
    }
}
