<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Builder;

/**
 * @mixin Builder
 * @mixin \Illuminate\Database\Query\Builder
 */
class BeatmapSet extends Model {
    use HasFactory;

    protected $table = 'beatmapsets';
    protected $primaryKey = 'beatmapset_id';
}
