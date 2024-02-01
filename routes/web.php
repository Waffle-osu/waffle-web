<?php

use App\Http\Controllers\ActivityGraphController;
use App\Http\Controllers\BeatmapController;
use App\Http\Controllers\BeatmapListController;
use App\Http\Controllers\DownloadPageController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RedirectController;
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
Route::get('/beatmaps', [BeatmapListController::class, 'show']);
Route::get('/download', [DownloadPageController::class, 'show']);

Route::get('/stats/activity-graph', [ActivityGraphController::class, 'show']);

Route::controller(LoginController::class)->group(function () {
    Route::post('/login', 'authenticate');
    Route::get("/logout", 'logout');
});

Route::controller(RedirectController::class)->group(function() {
    Route::get('/redirect/bancho/users/{userId}', 'banchoUsers');
    Route::get('/redirect/bancho/beatmapset/{setId}', 'banchoBeatmapsets');
});

Route::controller(BeatmapController::class)->group(function() {
    Route::get('/beatmapsets/{setId}', 'showScores');
    Route::get('/beatmapsets/{setId}/{beatmapId}', 'showScores');
    Route::get('/beatmapsets/{setId}/{beatmapId}/{mode}', 'showScores');
});

Route::middleware('auth')->group(function() {
    Route::get("/actions/favourite/{beatmapsetId}", [BeatmapController::class, 'favourite']);
    Route::get("/actions/unfavourite/{beatmapsetId}", [BeatmapController::class, 'unfavourite']);
});
