<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin Builder
 * @mixin \Illuminate\Database\Query\Builder
 *
 * @property int $beatmap_id
 * @property int $beatmapset_id
 * @property int $creator_id
 * @property string $filename
 * @property string $beatmap_md5
 * @property string $version
 * @property int $total_length
 * @property int $drain_time
 * @property int $count_objects
 * @property int $count_normal
 * @property int $count_slider
 * @property int $count_spinner
 * @property int $diff_hp
 * @property int $diff_cs
 * @property int $diff_od
 * @property float $diff_stars
 * @property int $playmode
 * @property int $ranking_status
 * @property string $last_update
 * @property string $submit_date
 * @property string $approve_date
 * @property string $beatmap_source
 * @property int $status_valid_from_version
 * @property int $status_valid_to_version
 */
class Beatmap extends Model {
    use HasFactory;

    protected $table = 'beatmaps';
    protected $primaryKey = 'beatmap_id';
}
