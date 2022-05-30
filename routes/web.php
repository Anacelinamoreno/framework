<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CasillaControler;
use App\Http\Controllers\CandidatoController;
use App\Http\Controllers\EleccionController;
use App\Http\Controllers\VotoController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\PDFController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('casilla/pdf', [CasillaControler::class,'generatepdf']);
Route::get('candidato/pdf',[CandidatoController::class,'generatepdf']);
Route::resource('casilla',CasillaControler::class);
Route::resource('candidato',CandidatoController::class);
Route::resource('eleccion',EleccionController::class);
Route::resource('voto',VotoController::class);

Route::get('preview', [PDFController::class,'preview']);
Route::get('download', [PDFController::class, 'download'])->name('download');
/*
Route::get('/login','App\Http\Controllers\Auth\LoginController@index');
Route::get('/login/facebook','App\Http\Controllers\Auth\LoginController@redirectToFacebookProvider');
Route::get('/login','callback','App\Http\Controllers\Auth\LoginController@handleProviderFacebookCallback'); */


Route::get('/login', [LoginController::class,'index']);
Route::get('/logout', [LoginController::class,'logout']);
Route::get('/login/facebook/', [LoginController::class,"redirectToFacebookProvider"]);
Route::get('/login/facebook/callback', [LoginController::class,"handleProviderFacebookCallback"]);


//Route::middleware(['auth'])->group(function(){
    //Route::resource('voto', VotoController::class);
//});
