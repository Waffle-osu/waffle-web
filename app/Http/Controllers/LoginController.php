<?php

namespace App\Http\Controllers;

use App\Models\User;
use http\Cookie;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades;

class LoginController extends Controller {
    public function authenticate(Request $request) {
        $passedCredentials = $request->validate([
            "username" => ["required"],
            "password" => ["required"],
        ]);

        $internalResponse = Http::post(env("WAFFLE_BANCHO_WEB_URL") . "/internal/do-auth", $passedCredentials);

        if($internalResponse->serverError()) {
            return redirect('/login/invalid?r=s');
        } else if($internalResponse->successful()) {
            $cookie = Facades\Cookie::make("ww-login-token", $internalResponse->body());

            return redirect('/')->withCookie($cookie);
        } else {
            return redirect('/login/invalid');
        }
    }
}
