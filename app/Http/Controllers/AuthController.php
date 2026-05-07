<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    //
    public function register()
    {
        return view('auth.register');
    }


    public function registerProcess(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:150',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6'
        ], [
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
        ]);

        // VALIDATION FAILED
        if ($validator->fails()) {

            return back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Mohon periksa kembali form register');
        }
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'provider' => 'LOCAL'
        ]);

        return redirect('/login')
            ->with('success', 'Register berhasil');
    }

    public function login()
    {
        // Auth::logout();
        if (Auth::check()) {
            return view('auth.account');
        } else {
            return view('auth.login');
        }
    }

    public function loginProcess(Request $request)
    {
        $cred = [
            'email' => $request->email,
            'password' => $request->password,
            'status' => 'ACTIVE'
        ];

        if (Auth::attempt($cred)) {

            User::where('id', Auth::id())
                ->update([
                    'last_login_at' => now()
                ]);

            return redirect('/');
        }

        return back()
            ->with('error', 'Email atau password salah');
    }

    public function logout()
    {
        Auth::logout();

        return redirect('/login');
    }

    public function googleRedirect()
    {
        return Socialite::driver('google')
            ->stateless()
            ->redirect();
    }

    public function googleCallback()
    {
        $googleUser = Socialite::driver('google')
            ->stateless()
            ->user();

        $user = User::where('email', $googleUser->email)
            ->first();

        if (!$user) {

            $user = User::create([
                'google_id' => $googleUser->id,
                'name' => $googleUser->name,
                'email' => $googleUser->email,
                'avatar' => $googleUser->avatar,
                'provider' => 'GOOGLE',
                'status' => 'ACTIVE',
                'email_verified_at' => now()
            ]);
        }

        Auth::login($user);

        return redirect('/');
    }
}
