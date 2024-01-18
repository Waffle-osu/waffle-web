<?php

use App\Http\Controllers\ActivityGraphController;
use App\Http\Controllers\BeatmapListController;
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
    Route::get('/beatmaps/{status}', 'show_with_status');
});

Route::get('/stats/activity-graph', [ActivityGraphController::class, 'show']);
Route::post('/login', [LoginController::class, 'authenticate']);
