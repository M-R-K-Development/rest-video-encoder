<?php namespace Rve\Http\Controllers\Files;
 
use Rve\Http\Controllers\Controller;

class FilesController extends Controller {
	
	public function __construct() {
		$this->middleware('auth');
	}

	public function uploader() {
		$user = \Auth::user();
		$userToken = \Rve\Services\UserToken::refreshToken($user);
		
		return \View::make('files.uploader')
					->with('token', $userToken->token);
	}
}
