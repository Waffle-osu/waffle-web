<?php

namespace App\Hashing;

use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Support\Arr;

class OsuHasher implements Hasher {

    /**
     * @var int Default BCrypt cost
     */
    protected int $rounds = 10;
    public function info($hashedValue) {
        $fixedBcrypt = str_replace('$2a$', '$2y', $hashedValue);

        return password_get_info($fixedBcrypt);
    }

    public function make($value, array $options = []) {
        //Using Arr::get to be able to supply a default
        //in case 'cost' isn't defined in $options
        $cost = Arr::get($options, 'cost', $this->rounds);

        $md5pw = md5($value);
        $hashed = password_hash($md5pw, PASSWORD_BCRYPT, [
            'cost' => $cost
        ]);

        return str_replace('$2y$', '$2a$', $hashed);
    }

    public function check($value, $hashedValue, array $options = []) {
        $hashedValue = str_replace('$2a$', '$2y$', $hashedValue);
        $md5value = md5($value);

        return password_verify($md5value, $hashedValue);
    }

    public function needsRehash($hashedValue, array $options = []) {
        $cost = Arr::get($options, 'cost', $this->rounds);
        $hashedValue = str_replace('$2a$', '$2y$', $hashedValue);

        return password_needs_rehash($hashedValue, PASSWORD_BCRYPT, [
            'cost' => $cost
        ]);
    }
}
