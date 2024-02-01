<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * @mixin Builder
 * @mixin \Illuminate\Database\Query\Builder
 *
 * @property int $score_id
 * @property int $beatmap_id
 * @property int $beatmapset_id
 * @property int $user_id
 * @property int $playmode
 * @property int $score
 * @property int $max_combo
 * @property string $rating
 * @property int $hit300
 * @property int $hit100
 * @property int $hit50
 * @property int $hitMiss
 * @property int $hitGeki
 * @property int $hitKatu
 * @property int $enabled_mods
 * @property bool $perfect
 * @property bool $passed
 * @property string $date
 * @property bool $leaderboard_best
 * @property bool $mapset_best
 * @property string $score_hash
 * @property int $client_version
 */
class Score extends Model {
    protected $table = 'scores';
    protected $primaryKey = 'score_id';
    public $incrementing = true;

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'date' => 'datetime',
    ];

    /**
     * @return Score[]
     */
    public static function GetBeatmapLeaderboards(string $beatmap_id, int $mode): array {
        $sql = "
            SELECT
                ROW_NUMBER() OVER (ORDER BY score DESC) AS 'online_rank',
                users.username,
                scores.*
            FROM
                waffle.scores
            LEFT JOIN
                 waffle.users ON scores.user_id = users.user_id
            WHERE
                beatmap_id = ?       AND
                leaderboard_best = 1 AND
                passed = 1           AND
                playmode = ?
            ORDER BY scores.score DESC
        ";

        $scoreResults = DB::select($sql, [
            $beatmap_id, $mode
        ]);

        return $scoreResults;
    }
}
