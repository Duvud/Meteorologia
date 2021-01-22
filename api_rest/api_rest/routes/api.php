<?php
use App\Http\Controllers\BalizaController;
use App\Models\Baliza;
use App\Http\Controllers\PeticionController;
use App\Http\Controllers\UserController;
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

Route::post("register", [UserController::class, "register"]);
Route::post("login", [UserController::class, "login"]);
Route::get('balizas',[BalizaController::class,'index'])/*->middleware('auth:sanctum')*/;

Route::middleware('auth:api')->group(function() {

    Route::get('balizas/{baliza}',[BalizaController::class,'show']);
    Route::get("user", [UserController::class, "user"]);
    Route::resource('peticion', PeticionController::class);
});
