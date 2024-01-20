<?php

use App\Http\Controllers\ActivityGraphController;
use App\Http\Controllers\BeatmapListController;
use App\Http\Controllers\DownloadPageController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\LoginController;
use http\Env\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [IndexController::class, 'show']);

Route::controller(BeatmapListController::class)->group(function() {
    Route::get('/beatmaps', 'show');
    Route::get('/beatmaps/{status}', 'status');
});

Route::get('/redirect/bancho/users/{userId}', function(string $userId) {
    return redirect("https://osu.ppy.sh/u/" . $userId);
});

Route::get('/download', [DownloadPageController::class, 'show']);

Route::get('/stats/activity-graph', [ActivityGraphController::class, 'show']);
Route::post('/login', [LoginController::class, 'authenticate']);
