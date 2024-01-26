<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Builder;

/**
 * @mixin Builder
 * @mixin \Illuminate\Database\Query\Builder
 *
 * @property int $message_id
 * @property int $beatmapset_id
 * @property int $user_id
 * @property User $user
 */
class BeatmapFavourites extends Model {
    use HasFactory;

    protected $table = 'beatmap_favourites';
    protected $primaryKey = 'favourite_id';
    public $incrementing = true;
}
