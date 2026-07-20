<?php

use App\Http\Controllers\ProfileController;

use App\Http\Controllers\GuestController;

use App\Http\Controllers\SimulatorController;

use Illuminate\Support\Facades\Route;

use App\Http\Traits\Bingo75;
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

Route::get('/', [GuestController::class, 'home'])->name('home');
Route::get('/home', [GuestController::class, 'render'])->name('renderHome');

Route::get('/support', [GuestController::class, 'home'])->name('support');

Route::get('/policies', [GuestController::class, 'home'])->name('policies');

/**
 * |--------------------------------------------------------------------------
 * | Simulator Routes
 * |-------------------------------------------------------------------------- 
 */
Route::get('/simulator', [SimulatorController::class, 'render'])->name('simulator');

Route::post('/simulator/cookie', [SimulatorController::class, 'storage'])->name('simulator.storage');
Route::post('/simulator/forget', [SimulatorController::class, 'forget'])->name('simulator.forget');

Route::post('/simulator/start', [SimulatorController::class, 'start'])->name('simulator.start');

Route::post('/simulator/loading', [SimulatorController::class, 'loading'])->name('simulator.loading');

Route::get('/simulator/game', [SimulatorController::class, 'game'])->name('simulator.game');
Route::get('/simulator/game2', [SimulatorController::class, 'game2'])->name('simulator.game2');
Route::get('/simulator/game3', [SimulatorController::class, 'game3'])->name('simulator.game3');

Route::post('/simulator/sync', [SimulatorController::class, 'sync'])->name('simulator.sync');

Route::get('/simulator/generator/carton75/{count}', [SimulatorController::class, 'generator'])->name('generator');


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
