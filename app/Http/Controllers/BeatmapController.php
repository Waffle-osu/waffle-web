<?php

namespace App\Http\Controllers;

use App\Models\Beatmap;
use App\Models\BeatmapFavourites;
use App\Models\BeatmapSet;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BeatmapController extends Controller {
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

    private function getDifficultyInfo(string $beatmapId) {

    }

    public function showScores(string $setId, string $beatmapId = '') {
        $user = Auth::user();

        $beatmapset = BeatmapSet::where('beatmapset_id', $setId)->first();

        if($beatmapset == null) {
            return '404';
        }

        $difficulties = Beatmap::where('beatmaps.beatmapset_id', $setId)->leftJoin('osu_beatmap_difficulty', function($q) {
            $q->on('osu_beatmap_difficulty.beatmap_id', '=', 'beatmaps.beatmap_id');
        })->groupBy('beatmaps.beatmap_id')->get()->reverse()->values();

        if(count($difficulties) == 0) {
            return '404';
        }

        $currentDifficulty = null;

        for($i = 0; $i != count($difficulties); $i++) {
            //If a $beatmapId is specified, we search for it
            //If there's none, just take the first one
            if($difficulties[$i]->beatmap_id == $beatmapId || $beatmapId == '') {
                $currentDifficulty = $difficulties[$i];
                break;
            }
        }

        $favourites = BeatmapFavourites::where('beatmapset_id', $setId)->leftJoin('users', function($q) {
            $q->on('users.user_id', '=', 'beatmap_favourites.user_id');
        })->get(['username', 'users.user_id']);

        return view('beatmap_info', [
            "user" => $user,
            "beatmapset" => $beatmapset,
            "currentDiff" => $currentDifficulty,
            "difficulties" => $difficulties,
            "favourites" => $favourites
        ]);
    }
}
