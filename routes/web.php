<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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
    return view('layouts.welcome');
});

Route::get('/ppepe',function(){ return view('layouts.welcome'); });
Route::get('/pagina1',function(){ return view('layouts.welcome'); });
Route::get('/pagina2',function(){ return view('layouts.welcome'); });
Route::get('/comentarios',function(){ return view('layouts.welcome'); });
Route::get('/contacto',function(){ return view('layouts.welcome'); });

Auth::routes(['verify'=>true]);

Route::get('/home', 'HomeController@index')->name('home')->middleware('verified');

Route::apiResource('thought','ThoughtController');

Route::get('enviar-msn',function(){
    return view('mailContact.form-contacto');
});
Route::post('contact','MessageContactController@store')->name('contact.store')->middleware('throttle:7,1');

Route::resource('statuses','StatusesController');

Route::get('/adm', function(){
    
    if(Auth::user()->email!='alepabon@gmail.com')
        abort('403','No tienes permisos para acceder');
    
    //Artisan::call('migrate');
    // Artisan::call('queue:listen');
    //Artisan::call('queue:restart');
        
    // Artisan::call('config:cache');
    // Artisan::call('config:clear');
    
    // Artisan::call('route:cache');
    // Artisan::call('route:clear');
    
    // Artisan::call('optimize');
    // Artisan::call('optimize:clear');
    return "Proyecto optimizado";
})->middleware('auth');


