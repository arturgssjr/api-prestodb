<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/', 'HomeController@welcome')->name('welcome');

Route::middleware('auth')->group(function () {
    Route::get('/home', 'HomeController@index')->name('home');
});

Route::namespace('OAuth')->prefix('oauth')->name('oauth.')->middleware('auth')->group(function () {
    Route::resource('/client-credentials', 'ClientCredentialsController');
    Route::resource('/authorization-code', 'AuthorizationCodeController');
    Route::resource('/password-grant', 'PasswordGrantController');
    Route::resource('/personal-access', 'PersonalAccessController');
});
