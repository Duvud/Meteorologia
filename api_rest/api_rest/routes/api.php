<?php

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

Route::get('balizas','BalizaController@index');
Route::get('balizas/{baliza}','BalizaController@show');
Route::post('balizas','BalizaController@store');
Route::put('balizas/{baliza}','BalizaController@update');
Route::delete('balizas/{baliza}','BalizaController@delete');
