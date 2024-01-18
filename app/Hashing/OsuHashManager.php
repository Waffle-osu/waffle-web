<?php

use App\Hashing\OsuHasher;
use Illuminate\Hashing\HashManager;

class OsuHashManager extends HashManager {
    public function createBcryptDriver()
    {
        return new OsuHasher();
    }
}
