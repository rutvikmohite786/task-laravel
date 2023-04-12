<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Hash;
use App\Models\UserVerification;
use App\Jobs\VerificationJob;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('guestcustom');
    }
    public function index()
    {   
        return view('auth.login');
    }

    public function customLogin(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
            if (auth()->guard('web')->attempt($credentials)) {
                return redirect()->intended('/user/new');
            } else {
                return redirect()->back()->withErrors(['error' => config('const.password_check')]);
            }
    }

    public function registration()
    {
        return view('auth.register');
    }

    public function customRegistration(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        $data = $request->all();
        $password = Hash::make($request->password);
        $otp = random_int(1000, 9999);
        UserVerification::create([
          'email'=>$request->email,
          'otp'=>$otp
        ]);
        $details = [
            'email' => $request->email,
            'name'=>$request->name,
            'otp'=>$otp
          ];
        dispatch(new VerificationJob($details));
        return redirect()->route('otp',['phone'=>$request->phone,'email'=>$request->email,'name'=>$request->name,'password'=>$request->password]);
    }
    public function dashboard()
    {
        if (Auth::check()) {
            return view('dashboard');
        }
        return redirect("login")->withSuccess('You are not allowed to access');
    }

    public function signOut()
    {
        Session::flush();
        Auth::logout();
        return Redirect('login');
    }
}