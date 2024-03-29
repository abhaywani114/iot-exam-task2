<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Jobs\SendOTPJob;
use Illuminate\Support\Facades\Mail;
use \Log;
use App\Models\User;
use \Auth;

class LoginController extends Controller
{
    public function loginView() {
        return view('auth.login_1');
    }
    
    public function getOTP(Request $request) {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email|exists:users',
            ]);    
            
			if ($validator->fails()) {
                throw new \Exception(implode(",",$validator->messages()->all()));
            } 
        
            
            $email = $request->email;
            $otp = mt_rand(100000, 999999);
            
            $request->session()->put('otp', $otp);
            $request->session()->put('email', $email);

            $user = User::where('email', $email)->first();
            if ($user->status == 'inactive')
                throw new \Exception("Your account is inactive");
            
            \Log::info(["otp" => $otp ]);
            // dispatch(new SendOTPJob($email, $otp));
            Mail::to($email)->send(new \App\Mail\OTPNotification($otp));

            return view('auth.login_2', compact('email'));
        } catch (\Exception $e) {
			Log::info([
				"Error"	=>	$e->getMessage(),
				"File"	=>	$e->getFile(),
				"Line"	=>	$e->getLine()
			]);
            $msg = ["success" => false, "msg" =>	"Error: ". $e->getMessage()];
            return view('message', compact('msg'));
		}
    }
    
    public function verifyOTP(Request $request) {
        try {
            $validator = Validator::make($request->all(), [
                'otp' => 'required|numeric',
            ]);

            $email = $request->session()->get('email');

            $userOTP = $request->otp; // Assuming OTP is sent via form input
            $storedOTP = $request->session()->get('otp');
            
            $request->session()->remove('otp');

            if ($storedOTP != $userOTP) {
                throw new \Exception('Invalid OTP. Please try again.');
               
            }

            $user = User::where('email', $email)->first();
            if (!$user) {
                throw new \Exception('Invalid user. User not found');
            }
            Auth::login($user);

            return redirect()->route('dashboard.main')->with('success', 'OTP verified successfully.');
        } catch (\Exception $e) {
			Log::info([
				"Error"	=>	$e->getMessage(),
				"File"	=>	$e->getFile(),
				"Line"	=>	$e->getLine()
			]);
            $msg = ["success" => false, "msg" =>	"Error: ". $e->getMessage()];
            return view('message', compact('msg'));
		}
		
    }
    public function logout(Request $request) {
        try {
            Auth::logout();
            $msg = ["success" => true, "msg" =>	"You have been logged out."];
            return view('message', compact('msg'));
        } catch (\Exception $e) {
			Log::info([
				"Error"	=>	$e->getMessage(),
				"File"	=>	$e->getFile(),
				"Line"	=>	$e->getLine()
			]);
            $msg = ["success" => false, "msg" =>	"Error: ". $e->getMessage()];
            return view('message', compact('msg'));
		}
    }
}
