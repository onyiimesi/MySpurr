<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\BankAccountRequest;
use App\Http\Resources\V1\BankResource;
use App\Mail\V1\BankAccountVerifyMail;
use App\Models\V1\Bank;
use App\Models\V1\BankAccount;
use App\Models\V1\Talent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Hash;

class BankAccountController extends Controller
{

    use HttpResponses;

    public function banks()
    {
        $banks = Bank::get();

        $allbanks = BankResource::collection($banks);

        return [
            "status" => "true",
            "message" => "Bank List",
            "data" => $allbanks
        ];
    }

    public function add(BankAccountRequest $request)
    {
        $request->validated($request->all());

        BankAccount::create([
            'talent_id' => $request->talent_id,
            'account_number' => $request->account_number,
            'bank_name' => $request->bank_name,
            'account_name' => $request->account_name,
            'status' => "Not Verified"
        ]);

        return [
            "status" => "true",
            "message" => "Created Successfully"
        ];
    }

    public function pin(Request $request)
    {
        $request->validate([
            'pin' => 'required|numeric|digits:4|confirmed'
        ]);

        DB::beginTransaction();
        $user = Auth::user();
        $otpExpiresAt = now()->addMinutes(5);

        $talent = Talent::where('id', $user->id)->first();

        if(!empty($talent->talentpin)){
            return $this->error('', 400, 'Pin has already been created');
        }

        try {
            $pinHash = Hash::make($request->pin);
            $expiresAt = now()->addDays(30);

            $talent->talentpin()->create([
                'pin_hash' => $pinHash,
                'expires_at' => $expiresAt,
                'ip_address' => $request->ip(),
                'device_info' => $request->header('User-Agent'),
                'attempts' => 0
            ]);

            $otpExpiresAt = now()->addMinutes(10);
            $talent->update([
                'otp' => $this->generateOTP(),
                'otp_expires_at' => $otpExpiresAt
            ]);
            
            Mail::to($user->email)->send(new BankAccountVerifyMail($talent));
            DB::commit();
        } catch (\Exception $e){
            DB::rollBack();
            return $this->error('error', 400, 'Email sending failed!. Try again');
        }

        return $this->success(null, "Updated Successfully", 200);
    }

    public function verify(Request $request)
    {
        $user = Auth::user();

        $bankAccount = BankAccount::where('talent_id', $user->id)
        ->where('otp', $request->otp)
        ->where('otp_expires_at', '>', now())
        ->first();

        if ($bankAccount) {
            $bankAccount->update([
                'otp' => NULL,
                'otp_expires_at' => NULL,
                'status' => "verified"
            ]);
            return [
                "status" => "true",
                "message" => "Verified Successfully"
            ];
        } else {
            // OTP is invalid or expired
            return $this->error('error', 400, 'OTP is invalid or expired');
        }
    }

    function generateOTP() {
        return rand(100000, 999999);
    }
}
