<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class DownloadPageController extends Controller {
    public function show() {
        return view('download_page', [
            "user" => Auth::user()
        ]);
    }
}
