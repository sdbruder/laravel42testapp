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

Route::get('/', function()
{
	return View::make('pages.home');
});


 // Authentication routes
 Route::get( 'auth/login',            'AuthController@getLogin'    );
 Route::post('auth/login',            'AuthController@postLogin'   );
 Route::get( 'auth/logout',           'AuthController@getLogout'   );
 Route::get( 'auth/register',         'AuthController@getRegister' );
 Route::post('auth/register',         'AuthController@postRegister');
 // OAuth Authentication routes
 Route::get('auth/{driver}',          'AuthController@redirectToProvider'    );
 Route::get('auth/{driver}/callback', 'AuthController@handleProviderCallback');

 // Contacts controller
 Route::resource('contact', 'ContactsController');

