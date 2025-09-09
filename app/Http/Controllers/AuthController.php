<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $user = DB::table('users')
            ->where('username', $request->username)
            ->where('password', $request->password) // ← plain password match
            ->first();

        if ($user) {
            Auth::loginUsingId($user->id);
            return redirect()->intended('/dashboard');
        }

        return back()->withErrors(['Invalid login credentials.']);
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}
