<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;

class RedirectController extends Controller {
    public function banchoUsers($userId) {
        return redirect("https://osu.ppy.sh/u/" . $userId);
    }

    public function banchoBeatmapsets($beatmapsetId) {
        return redirect("https://osu.ppy.sh/s/" . $beatmapsetId);
    }
}
