<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * @mixin Builder
 * @mixin \Illuminate\Database\Query\Builder
 *
 * @property int $user_id
 * @property string $username
 * @property string $password
 * @property string $country
 * @property int $banned
 * @property string $banned_reason
 * @property int $privileges
 * @property string $joined_at
 * @property int $silenced_until
 */
class User extends Authenticatable {
    protected $table = 'users';
    protected $primaryKey = 'user_id';
    public $incrementing = true;

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'password' => 'hashed',
    ];
}
