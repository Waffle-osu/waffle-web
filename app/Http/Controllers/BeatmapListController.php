<?php

namespace App\Http\Controllers;

use App\Models\BeatmapSet;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BeatmapListController extends Controller {
    /**
     * handles /beatmaps
     */
    public function show(Request $request) {
        $user = Auth::user();

        $search = $request->input('search');
        $status = $request->input('status');
        $genre = $request->input('genre');
        $lang = $request->input('lang');
        $page = $request->input('lang');

        $resultsPerPage = 20;
        $genreSql = "";
        $langSql = "";

        if(!is_int($status)) {
            $status = 1;
        }

        if(!is_int($genre)) {
            $genre = 0;
            $genreSql = "AND result.genre_id = :genre";
        }

        if(!is_int($lang)) {
            $lang = 0;
            $langSql = "AND result.language_id = :lang";
        }

        if(!is_int($page)) {
            $page = 0;
        }

        $query = DB::select("
            SELECT * FROM (
                SELECT
                    ROWNUM() AS 'row_number',
                    result.beatmapset_id,
                    result.artist,
                    result.title,
                    result.creator,
                    result.source,
                    result.tags,
                    result.has_video,
                    result.has_storyboard,
                    result.final_rating_sum AS 'rating_sum',
                    result.final_votes AS 'votes',
                    result.ranking_status,
                    result.approve_date,
                    result.genre_id,
                    result.language_id,
                    result.beatmap_pack
                FROM (
                    SELECT
                        beatmapsets.beatmapset_id,
                        beatmapsets.artist,
                        beatmapsets.title,
                        beatmapsets.creator,
                        beatmapsets.source,
                        beatmapsets.tags,
                        beatmapsets.has_video,
                        beatmapsets.has_storyboard,
                        beatmapsets.genre_id,
                        beatmapsets.language_id,
                        beatmapsets.beatmap_pack,
                        beatmap_ratings.rating_sum,
                        beatmap_ratings.votes,
                        beatmaps.approve_date,
                        beatmaps.ranking_status,
                        CASE WHEN beatmap_ratings.rating_sum IS NULL THEN 0 ELSE beatmap_ratings.rating_sum END AS 'final_rating_sum',
                        CASE WHEN beatmap_ratings.votes IS NULL THEN 1 ELSE beatmap_ratings.votes END AS 'final_votes'
                    FROM waffle.beatmapsets
                        LEFT JOIN waffle.beatmaps ON beatmaps.beatmapset_id = beatmapsets.beatmapset_id
                        LEFT JOIN waffle.beatmap_ratings ON beatmap_ratings.beatmapset_id = beatmapsets.beatmapset_id
                    WHERE ranking_status = ?
                    GROUP BY beatmaps.beatmapset_id
                ) result WHERE (
                    LOWER(result.title) LIKE CONCAT('%', ?, '%') OR
                    LOWER(result.artist) LIKE CONCAT('%', ?, '%') OR
                    LOWER(result.creator) LIKE CONCAT('%', ?, '%') OR
                    LOWER(result.source) LIKE CONCAT('%', ?, '%') OR
                    LOWER(result.tags) LIKE CONCAT('%', ?, '%')
                )
            ) paginated WHERE `row_number` BETWEEN ? * ? AND (? * ?) + ?
        ", [$status, $search, $search, $search, $search, $search, $page, $resultsPerPage, $page, $resultsPerPage, $resultsPerPage]);

        return view('beatmap_list', [
            'user' => $user,
            'page' => $page,
            'resultsPerPage' => $resultsPerPage,
            'beatmaps' => $query
        ]);
    }
}
