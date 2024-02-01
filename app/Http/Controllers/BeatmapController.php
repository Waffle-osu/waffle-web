<?php

namespace App\Http\Controllers;

use App\Models\Beatmap;
use App\Models\BeatmapFavourites;
use App\Models\BeatmapSet;
use App\Models\Score;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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

    public function showScores(string $setId, string $beatmapId = '', string $mode = '') {
        $user = Auth::user();

        $beatmapset = BeatmapSet::where('beatmapset_id', $setId)->first();

        if($beatmapset == null) {
            return '404';
        }

        $difficulties = Beatmap::where('beatmaps.beatmapset_id', $setId)->leftJoin('osu_beatmap_difficulty', function($q) {
            $q->on('osu_beatmap_difficulty.beatmap_id', '=', 'beatmaps.beatmap_id');
        })->groupBy('beatmaps.beatmap_id')->orderBy('eyup_stars', 'asc')->get()->values();

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


        $sortedDiffs = [];

        //Sort by mode
        for($sortMode = 0; $sortMode != 4; $sortMode++) {
            for($i = 0; $i != count($difficulties); $i++) {
                if($difficulties[$i]->playmode == $sortMode) {
                    $sortedDiffs[] = $difficulties[$i];
                }
            }
        }

        $actualMode = $mode;

        if($actualMode == ''){
            $actualMode = 0;
        }

        //Don't allow stuff like osu!standard leaderboards on taiko maps
        if($currentDifficulty->playmode != 0 && $currentDifficulty->playmode != $mode) {
            $actualMode = $currentDifficulty->playmode;
        }

        $scores = Score::GetBeatmapLeaderboards($currentDifficulty->beatmap_id, $actualMode);

        return view('beatmap_info', [
            "user" => $user,
            "beatmapset" => $beatmapset,
            "currentDiff" => $currentDifficulty,
            "difficulties" => $sortedDiffs,
            "favourites" => $favourites,
            "scores" => $scores,
            "currentMode" => $actualMode
        ]);
    }
}
