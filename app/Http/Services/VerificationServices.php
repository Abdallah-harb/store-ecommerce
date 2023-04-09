<?php

namespace App\Http\Services;


use App\Models\User;
use App\Models\Users_verificationcodes;
use Illuminate\Support\Facades\Auth;

class VerificationServices
{
    /** set OTP code for mobile
     * @param $data
     *
     * @return Users_verificationcodes
     */

    public function setVerificationCode($data)
    {
        $code = mt_rand(100000, 999999);
        $data['code'] = $code;
        Users_verificationcodes::whereNotNull('user-id')->where(['user-id' => $data['user-id']])->delete();
        return Users_verificationcodes::create($data);
    }

    public function getSMSVerifyMessageByAppName($code)
    {
        $message = " is your verification code for your account";
        return $code.$message;
    }
/*

    public function checkOTPCode ($code){

        if (Auth::guard()->check()) {
            $verificationData = Users_verificationcodes::where('user_id',Auth::id()) -> first();

            if($verificationData -> code == $code){
                User::whereId(Auth::id()) -> update(['email_verified_at' => now()]);
                return true;
            }else{
                return false;
            }
        }
        return false ;
    }


    public function removeOTPCode($code)
    {
        Users_verificationcodes::where('code',$code) -> delete();
    }
*/

}
