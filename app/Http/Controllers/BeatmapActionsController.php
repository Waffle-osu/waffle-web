<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BeatmapActionsController extends Controller {
    public function favourite(string $setId) {
        $user = Auth::user();

        DB::select("INSERT INTO waffle.beatmap_favourites (beatmapset_id, user_id) VALUE (?, ?)", [
            $setId, $user->user_id
        ]);

        return back();
    }

    public function unfavourite(string $setId) {
        $user = Auth::user();

        DB::select("DELETE FROM waffle.beatmap_favourites WHERE beatmapset_id = ? AND user_id = ?", [
            $setId, $user->user_id
        ]);

        return back();
    }
}
