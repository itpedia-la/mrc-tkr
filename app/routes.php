<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

/**
 * Dashboard Route
 * ---------------
 */
Route::get('/', 'HomeController@home');

/**
 * User Route
 * ----------
*/
Route::get('user/login', 'UserController@login');
Route::post('user/login/submit', 'UserController@submit');
Route::get('user/logout','UserController@logout');