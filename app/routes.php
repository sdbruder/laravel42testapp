<?php

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

// Contacts Search AJAX
Route::post('contact/search', 'ContactsController@search');
// Contacts controller
Route::resource('contact', 'ContactsController');
