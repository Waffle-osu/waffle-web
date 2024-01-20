<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller {
    public function authenticate(Request $request) {
        $passedCredentials = $request->validate([
            "username" => ["required"],
            "password" => ["required"],
        ]);

        if(Auth::attempt($passedCredentials)) {
            $request->session()->regenerate();

            return back();
        }

        return redirect('/login/invalid');
    }

    public function logout(Request $request) {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return back();
    }
}
