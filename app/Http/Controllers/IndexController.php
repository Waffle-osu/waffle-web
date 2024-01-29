<?php

namespace App\Http\Controllers;

use App\Models\ChatMessage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class IndexController extends Controller {
    public static string $chatActionRegex = '/\\((?<title>[^)]*\\))\\[(?<link>[^\\]]*)\\]/i';

    public static function formatActionString(string $str) {
        try {
            $str = str_replace('ACTION', '', $str);

            preg_match(self::$chatActionRegex, $str, $matches);

            $title = $matches['title'];
            $link = $matches['link'];

            //return $matches[0];
            return [$title, $link];
        }catch(\Exception $e) {
            return ['', ''];
        }
    }

    public function show(): View {
        $chat_messages = ChatMessage::leftJoin('users', function($q) {
            $q->on('irc_log.sender', '=', 'users.user_id');
        })
            ->where('target', '=', '#osu') //Only #osu
            ->orderBy('message_id', 'desc') //Can't use time because WaffleBot messages are sent so fast they could have the same time
            ->take(10) //Limit to 10
            ->get()
            ->reverse()
            ->values();

        $user = Auth::user();

        $most_played = DB::select("
            SELECT
                plays,
                beatmapsets.artist,
                beatmapsets.title,
                beatmapsets.creator,
                beatmapsets.beatmapset_id,
                beatmapsets.creator_id,
                beatmapsets.creator
            FROM (
               SELECT
                   COUNT(*) AS 'plays',
                   beatmapset_id
               FROM
                   waffle.scores
               GROUP BY
                    beatmapset_id
            ) a
            LEFT JOIN
                waffle.beatmapsets ON a.beatmapset_id = beatmapsets.beatmapset_id
            ORDER BY plays DESC
            LIMIT 5
        ");

        return view('index', [
            'user' => $user,
            'messages' => $chat_messages,
            'most_played' => $most_played,
        ]);
    }
}
