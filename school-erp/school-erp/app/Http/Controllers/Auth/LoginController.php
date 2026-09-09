<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect(Auth::user()->dashboardRoute());
        }

        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            return back()->withErrors([
                'email' => 'ইমেইল অথবা পাসওয়ার্ড সঠিক নয়।',
            ])->onlyInput('email');
        }

        $request->session()->regenerate();

        $user = Auth::user();

        if ($user->status !== 'active') {
            Auth::logout();

            return back()->withErrors([
                'email' => 'আপনার অ্যাকাউন্টটি নিষ্ক্রিয় করা আছে। এডমিনের সাথে যোগাযোগ করুন।',
            ]);
        }

        return redirect()->intended($user->dashboardRoute());
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
