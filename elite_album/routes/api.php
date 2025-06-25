<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\API\ArtistController;
use App\Http\Controllers\API\AlbumController;

//login and logout routes
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    //api controllers
    Route::apiResource('artists', ArtistController::class);
    Route::apiResource('albums', AlbumController::class);

    //dashboard routes
    Route::get('/dashboard/total-albums', [DashboardController::class, 'totalSales']);
    Route::get('/dashboard/combined-sales', [DashboardController::class, 'combinedSales']);
    Route::get('/dashboard/top-artist', [DashboardController::class, 'topArtist']);
    Route::get('/dashboard/search-albums/{artist}', [DashboardController::class, 'albumsByArtist']);
});
