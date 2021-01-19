<?php
use App\Http\Controllers\BalizaController;
use App\Models\Baliza;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('balizas',[BalizaController::class,'index']);
Route::get('balizas/{baliza}',[BalizaController::class,'show']);
Route::post('balizas',[BalizaController::class,'store']);
Route::put('balizas/{baliza}',[BalizaController::class,'update']);
Route::delete('balizas/{baliza}',[BalizaController::class,'delete']);
