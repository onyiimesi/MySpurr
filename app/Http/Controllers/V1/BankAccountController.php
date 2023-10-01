<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\BankAccountRequest;
use App\Mail\V1\BankAccountVerifyMail;
use App\Models\V1\BankAccount;
use App\Models\V1\Talent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Traits\HttpResponses;

class BankAccountController extends Controller
{

    use HttpResponses;
    
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
            'pin' => ['required', 'max:4']
        ]);

        DB::beginTransaction();

        $user = Auth::user();
        $otpExpiresAt = now()->addMinutes(5);

        $talent = BankAccount::where('talent_id', $user->id)->first();

        if($talent->status != "verified"){

            $updatedRows = BankAccount::where('talent_id', $user->id)->update([
                'pin' => $request->pin,
                'otp' => $this->generateOTP(),
                'otp_expires_at' => $otpExpiresAt
            ]);

            if($updatedRows > 0) {
                try {
                    $talent = BankAccount::where('talent_id', $user->id)->first();
            
                    Mail::to($user->email)->send(new BankAccountVerifyMail($talent));
            
                    DB::commit();
            
                } catch (\Exception $e){
                    DB::rollBack();
                    return $this->error('error', 400, 'Email sending failed!. Try again');
                }
            } else {
                DB::rollBack();
                return $this->error('error', 400, 'Update failed');
            }

        }else{
            return $this->error('error', 400, 'Your account has been verified!');
        }

        return [
            "status" => "true",
            "message" => "Updated Successfully"
        ];
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
