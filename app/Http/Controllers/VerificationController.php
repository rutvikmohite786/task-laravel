<?php

namespace App\Http\Controllers;
use App\Models\UserVerification;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
   public function getOtp($phone,$email,$name,$password){
        return view('auth.otp',['name'=>$name,'password'=>$password,'phone'=>$phone,'email'=>$email]);
   }
   public function storeData(Request $request){
      $request->validate([
         'otp' => 'required'
      ]);
     $verification = UserVerification::where('email',$request->email)->where('otp',$request->otp);
     if($verification->exists()){
            User::create([
               'email'=>$request->email,
               'password'=>$request->password,
               'name'=>$request->name,
               'email_verified_at'=>Carbon::now()->toDateTimeString(),
               'phone'=>$request->phone
            ]);
            return redirect()->route('login')->with('message','Email Has been verified');
     }
     return redirect()->back()->with('error','Wrong otp please try again');
   }
}
