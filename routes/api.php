<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

use App\Http\Controllers\AccessController;
use App\Http\Controllers\SimulatorController;
use App\Http\Controllers\CartonsController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', [AccessController::class, 'register'])->name('register');
Route::post('/login', [AccessController::class, 'login'])->name('login');
Route::get('/auth', [AccessController::class, 'auth'])->name('auth');


Route::get('/storage', function(){
    Artisan::call('storage:link'); // Storage Link Images
    return response()->json([ 'response' => 'executed' ]);
});

Route::middleware('auth.api')->group(function(){

    Route::get('/confirmation', [AccessController::class, 'confirmation'])->name('confirmation');
    Route::get('/programmed', [AccessController::class, 'programmed'])->name('programmed');

});

// Route::middleware(['auth', 'system'])->group
// Route::group(function () {

    Route::get('/cartons', [CartonsController::class, 'cartons']);
    Route::get('/carton/{number}', [CartonsController::class, 'carton']);

    Route::get('/modes', [SimulatorController::class, 'modes'])->name('modes');
    

    /** 
     * ---------------------------------------- 
     * Call Fetch Simulator
     * ----------------------------------------
     * */
    
    Route::get('/modes', [SimulatorController::class, 'modes'])->name('modes');
    Route::get('/contexts', [SimulatorController::class, 'contexts'])->name('contexts');

    Route::get('/modes/{context_id}', [SimulatorController::class, 'getModes'])->name('modes.by.context');
    Route::get('/submodes/{mode_id}', [SimulatorController::class, 'getSubmodes'])->name('submodes.by.mode');
    

// });

