<?php

namespace App\Http\Controllers;

use App\Models\User;
use http\Cookie;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades;

class LoginController extends Controller {
    public function authenticate(Request $request) {
        $passedCredentials = $request->validate([
            "username" => ["required"],
            "password" => ["required"],
        ]);

        if(Auth::attempt($passedCredentials)) {
            $request->session()->regenerate();

            return redirect('/');
        }

        return redirect('/login/invalid');
    }
}
