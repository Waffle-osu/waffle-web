<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class BeatmapListController extends Controller {
    public function show() {
        $user = Auth::user();

        return view('beatmap_list', [
            'user' => $user,
        ]);
    }

    public function show_with_status(string $status) {
        $user = Auth::user();

        return view('beatmap_list', [
            'user' => $user,
        ]);
    }
}
