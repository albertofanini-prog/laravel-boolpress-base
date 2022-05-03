<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\PostController;

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

Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');

//Funzione per raggruppare le rotte, applicare cose comuni
    //Middleware: autentica
    //Namespace: cartella in cui deve essere creato controller e collegata la route
    //Name: aggiunge prefisso a name su route:list
    //Prefix assegna un prefisso comune alle rotte
Route::middleware('auth')->namespace('Admin')->name('admin.')->prefix('admin')->group(function(){

    Route::get('/home', 'HomeController@index')->name('home');

    //Resource posts
    //Ecc
    Route::resource('posts', 'PostController');

});

// Route::get('home', 'HomeController@index')->name('home');