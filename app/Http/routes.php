<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

//Uploader

Route::group(['middleware' => 'refresh-token'], function() {
	
	Route::get('/', 'HomeController@index');
	Route::get('home', 'HomeController@index');

	Route::get('/upload', 'Files@uploader');
	Route::get('/files', 'Files@files');
	Route::get('/videos', 'Videos@videos');
	Route::get('/users', 'Users@index');

	Route::get('tokens', 'Tokens@index');
	
	Route::controllers([
		'auth' => 'Auth\AuthController',
		'password' => 'Auth\PasswordController',
	]);

	/** VIDEO ENCODING SERVICES **/
	Route::group(['prefix' => 'rve/api/1.0/', 'namespace' => 'API\RVE'], function() {
		
		Route::resource('video-files', 'VideoFiles');
		Route::resource('tokens', 'Tokens');
		Route::get('handshake', 'Tokens@handshake');
		Route::resource('videos', 'Videos');
		Route::resource('status', 'Status');
		Route::resource('files', 'Files');
		Route::resource('users', 'Users');
	});
	
});
