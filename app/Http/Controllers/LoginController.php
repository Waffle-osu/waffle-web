<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller {
    public function authenticate(Request $request) {
        $passedCredentials = $request->validate([
            "username" => ["required"],
            "password" => ["required"],
        ]);

        $user = User::where('username', $passedCredentials['username'])->first();

        if($user === null) {
            return response()->redirectTo('/login/failed?reason=nf');
        }

        if(!Hash::check($passedCredentials['password'], $user->password, [
            'rounds' => 10
        ])) {
            return response()->redirectTo('/login/failed?reason=wp');
        }

        return 'hiii';
    }
}
