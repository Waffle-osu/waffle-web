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

        $userId = -1;

        if($user != null) {
            $userId = $user->user_id;
        }

        $lang = $request->input('lang');
        $search = $request->input('search');
        $status = $request->input('status');
        $genre = $request->input('genre');
        $page = $request->input('page');

        $resultsPerPage = 20;
        $genreSql = "TRUE";
        $langSql = "TRUE";

        if($search === null) {
            $search = "";
        }

        if(!is_numeric($status)) {
            $status = 1;
        }

        if(!is_numeric($genre)) {
            $genre = 0;
        }

        if(!is_numeric($lang)) {
            $lang = 0;
        }

        if(!is_numeric($page)) {
            $page = 0;
        }

        $sqlParams =      [$userId, $status, $search, $search, $search, $search, $search];
        $sqlParamsCount = [$userId, $status, $search, $search, $search, $search, $search];

        //if($genre !== 0 && $genre !== "0") {
        if($genre != 0) {
            $sqlParams[] = $genre;
            $sqlParamsCount[] = $genre;
            $genreSql = "result.genre_id = ?";
        }

        //if($lang !== 0 && $lang !== "0") {
        if($lang != 0) {
            $sqlParams[] = $lang;
            $sqlParamsCount[] = $lang;
            $langSql = "result.language_id = ?";
        }

        $sqlParams[] = $page;
        $sqlParams[] = $resultsPerPage;
        $sqlParams[] = $resultsPerPage;
        $sqlParams[] = $page;
        $sqlParams[] = $resultsPerPage;

        $nonPaginatedQuery = "
            SELECT * FROM (
                SELECT
                    ROWNUM() AS 'row_number',
                    result.beatmapset_id,
                    result.artist,
                    result.title,
                    result.creator,
                    result.creator_id,
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
                    result.beatmap_pack,
                    (
                        SELECT COUNT(*) FROM scores WHERE scores.beatmapset_id = result.beatmapset_id
                    ) as 'plays',
                    (
                        SELECT COUNT(*) FROM beatmap_favourites WHERE beatmap_favourites.beatmapset_id = result.beatmapset_id AND beatmap_favourites.user_id = ?
                    ) as 'favourited'
                FROM (
                    SELECT
                        beatmapsets.beatmapset_id,
                        beatmapsets.artist,
                        beatmapsets.title,
                        beatmapsets.creator,
                        beatmapsets.creator_id,
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
                    ORDER BY beatmaps.approve_date DESC
                ) result WHERE (
                    LOWER(result.title) LIKE CONCAT('%', ?, '%') OR
                    LOWER(result.artist) LIKE CONCAT('%', ?, '%') OR
                    LOWER(result.creator) LIKE CONCAT('%', ?, '%') OR
                    LOWER(result.source) LIKE CONCAT('%', ?, '%') OR
                    LOWER(result.tags) LIKE CONCAT('%', ?, '%')
                ) AND $genreSql AND $langSql
            ) paginated
        ";

        //Kinda suboptimal but it does work
        $query = DB::select("
            $nonPaginatedQuery WHERE `row_number` BETWEEN ? * ? AND ((? * ?) + ?)
        ", $sqlParams);

        $theFuck = str_replace("SELECT * FROM (", "SELECT COUNT(*) AS 'count' FROM (", $nonPaginatedQuery);

        $nonPaginatedResultCountQuery = DB::select(
            $theFuck
        , $sqlParamsCount);

        return view('beatmap_list', [
            'user' => $user,
            'page' => $page,
            'resultsPerPage' => $resultsPerPage,
            'beatmaps' => $query,
            'mapCount' => $nonPaginatedResultCountQuery[0]->count,
            'genre' => $genre,
            'language' => $lang,
            'status' => $status
        ]);
    }

    public static function formatGenreId($genre_id) {
        return match ($genre_id) {
            1 => "Unspecified",
            2 => "Video Game",
            3 => "Anime",
            4 => "Rock",
            5 => "Pop",
            6 => "Other",
            7 => "Novelty",
            9 => "Hip Hop",
            10 => "Techno",
            default => "",
        };
    }

    public static function formatLanguageId($languageId) {
        return match ($languageId) {
            1 => "(Other)",
            2 => "(English)",
            3 => "(Japanese)",
            4 => "(Chinese)",
            5 => "(Instrumental)",
            6 => "(Korean)",
            7 => "(French)",
            8 => "(German)",
            9 => "(Swedish)",
            10 => "(Spanish)",
            11 => "(Italian)",
            default => "",
        };
    }
}
