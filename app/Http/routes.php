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
	
	Route::get('/upload', 'Files\FilesController@uploader');
	Route::get('/files', 'Files\FilesController@files');
	
	Route::get('/', 'WelcomeController@index');

	Route::get('home', 'HomeController@index');

	Route::get('videos', 'Videos\Videos@videos');

	Route::get('tokens', 'Tokens\Tokens@index');

	Route::controllers([
		'auth' => 'Auth\AuthController',
		'password' => 'Auth\PasswordController',
	]);

	/** VIDEO ENCODING SERVICES **/
	Route::group(['prefix' => 'rve/api/1.0/'], function() {
		
		Route::resource('video-files', 'API\RVE\VideoFiles');
		Route::resource('tokens', 'API\RVE\Tokens');
		Route::get('handshake', 'API\RVE\Tokens@handshake');
		Route::resource('videos', 'API\RVE\Videos');
		Route::resource('status', 'API\RVE\Status');
		Route::resource('files', 'API\RVE\Files');
	});
	
});
