<?php

namespace App\Http\Controllers\Frontend\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\SigninRequest;
use App\Http\Requests\signupRequest;
use App\Repositories\EmailVerificationRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticationController extends Controller
{
    public function signin()
    {
        if (Auth::check()) {
            if (Auth::user()->hasRole('customer')) {
                return to_route('home');
            } else {
                return to_route('root');
            }
        }
        return view('frontend.auth.signin');
    }
    public function signup()
    {
        if (Auth::check()) {
            if (Auth::user()->hasRole('customer')) {
                return to_route('home');
            } else {
                return to_route('root');
            }
        }
        return view('frontend.auth.signup');
    }

    public function signinRequest(SigninRequest $loginRequest)
    {
        $email = $loginRequest->email;
        $credentials = $loginRequest->only('email', 'password');

        $user = UserRepository::findByEmail($email);

        if (!$user) {
            return $this->redirectBackWithError('Invalid email');
        }

        if (!Auth::attempt($credentials)) {
            return $this->redirectBackWithError('Invalid password');
        }

        if ($user->hasRole('customer')) {
            return to_route('home');
        }

        return to_route('root');
    }

    private function redirectBackWithError($errorMessage)
    {
        return back()->with('error', $errorMessage);
    }


    public function signupRequest(signupRequest $request)
    {

        if (!config('mail.mailers.smtp.username') || !config('mail.mailers.smtp.password')) {
            return back()->with('error', 'Now you can not do signup because admin have not configured signup yet');
        }
        $user = UserRepository::storeByRequest($request);
        $user->assignRole('customer');
        EmailVerificationRepository::sendMailByUser($user);
        return to_route('signin')->with('success', 'Sign Up successfully done! Please check your email inbox or spam');
    }

    public function varification($token)
    {
        $varificationCode = EmailVerificationRepository::query()->where('token', $token)->first();
        if (!$varificationCode) {
            return to_route('signin')->with('error', 'This Email already varified!');
        }
        UserRepository::emailVarifyAt($varificationCode->user);
        $varificationCode->delete();
        return to_route('signin')->with('success', 'Email successfully varified! But wait for authorize confirmation');
    }

    public function signout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return to_route('signin')->with('success', 'You logout successfully');
    }
}
