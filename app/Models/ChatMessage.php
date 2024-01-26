<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin Builder
 * @mixin \Illuminate\Database\Query\Builder
 *
 * @property int $message_id
 * @property int $sender
 * @property string $target
 * @property string $message
 * @property string $date
 */
class ChatMessage extends Model {
    protected $table = 'irc_log';
    protected $primaryKey = 'message_id';
    public $incrementing = true;

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'date' => 'datetime',
    ];
}
