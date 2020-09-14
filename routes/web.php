<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::get('/home', 'HomeController@index')->name('home');

Route::namespace('OAuth')->prefix('oauth')->name('oauth.')->middleware('auth')->group(function () {
    Route::resource('/client-credentials', 'ClientCredentialsController');
    Route::resource('/authorization-code', 'AuthorizationCodeController');
    Route::resource('/password-grant', 'PasswordGrantController');
    Route::resource('/personal-access', 'PersonalAccessController');
});
