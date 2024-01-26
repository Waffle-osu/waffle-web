<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Builder;

/**
 * @mixin Builder
 * @mixin \Illuminate\Database\Query\Builder
 *
 * @property int $beatmapset_id
 * @property int $creator_id
 * @property string $artist
 * @property string $title
 * @property string $source
 * @property string $creator
 * @property string $tags
 * @property bool $has_video
 * @property bool $has_storyboard
 * @property float $bpm
 * @property int $genre_id
 * @property int $language_id
 * @property string $beatmap_pack
 */
class BeatmapSet extends Model {
    use HasFactory;

    protected $table = 'beatmapsets';
    protected $primaryKey = 'beatmapset_id';
}
