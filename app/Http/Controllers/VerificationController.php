<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VerificationController extends Controller
{
   public function getOtp($name,$email,$password,$phone){
        return view('auth.otp',['name'=>$name,'password'=>$password,'phone'=>$phone,'email'=>$email]);
   }
   public function storeData(Request $request){
      dd($request->all());
   }
}
