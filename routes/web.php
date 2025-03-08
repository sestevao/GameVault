<?php

use App\Http\Controllers\ConsoleController;
use App\Http\Controllers\ConsoleOwnerController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\GenreController;
use Illuminate\Support\Facades\Route;

/*Route::get('/', [GameController::class, 'index'])->name('home');
Route::patch('{id}', [GameController::class, 'update']);
Route::post('store', [GameController::class, 'store']);
Route::delete('{id}', [GameController::class, 'destroy']);

Route::post('genres/store', [GenreController::class, 'store']);*/

Route::resource('/', GameController::class)->except(['create', 'show', 'edit']);

Route::prefix('games')->name('games.')->group(function () {
    Route::post('store', [GameController::class, 'store'])->name('store');
    Route::patch('{id}', [GameController::class, 'update'])->name('update');
    Route::delete('{id}', [GameController::class, 'destroy'])->name('destroy');
});

Route::prefix('genres')->name('genres.')->group(function () {
    Route::post('store', [GenreController::class, 'store'])->name('store');
});
