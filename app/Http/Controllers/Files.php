<?php 
/**
* Files Controller
* Back end related functions
* @author  Gregoire Duché <greg.duche@mrkdevelopment.com>
* @copyright  M R K Development Pty Ltd.
* @license GNU GENERAL PUBLIC LICENSE
*/ 
namespace Rve\Http\Controllers;
 
use Rve\Http\Controllers\Controller;

class Files extends Controller {
	
	/**
	 * Construct the class using the middleware Auth
	 */
	public function __construct() {
		$this->middleware('auth');
	}

	/**
	 * Upload a video file interface
	 * @return String the HTML View
	 */
	public function uploader() {
		$user = \Auth::user();
		$userToken = \Rve\Services\UserToken::refreshToken($user);
		
		return \View::make('files.uploader')
					->with('token', $userToken->token);
	}

	/**
	 * Display a list of all the files that were uploaded by the connected user
	 * @return String the HTML View
	 */
	public function files() {
		
		$user = \Auth::user();
		$files = \Rve\Models\File::where('user_id', '=', $user->id)
								->get();
		
		return \View::make('files.list')
					->with('files', $files);
	}
}
