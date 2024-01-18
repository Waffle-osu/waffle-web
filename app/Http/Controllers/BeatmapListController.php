<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class BeatmapListController extends Controller {
    /**
     * handles /beatmaps
     */
    public function show() {
        $user = Auth::user();

        return view('beatmap_list', [
            'user' => $user,
        ]);
    }

    /**
     * handles /beatmaps/{status}
     * @param string $status What beatmap status is being queried. Ranked? Approved? Waffle only?
     */
    public function status(string $status) {
        $user = Auth::user();

        return view('beatmap_list', [
            'user' => $user,
        ]);
    }
}
