<?php 
/**
* Tokens
* Handles the token creation
* @author  Gregoire Duché <greg.duche@mrkdevelopment.com>
* @copyright  M R K Development Pty Ltd.
* @license GNU GENERAL PUBLIC LICENSE
*/
namespace Rve\Http\Controllers;

use Rve\Http\Requests;
use Rve\Http\Controllers\Controller;

use Illuminate\Http\Request;

class Tokens extends Controller {

	/**
	 * Construct
	 *
	 * @return Response
	 */
	public function __construct()
	{
		$this->middleware('auth');
	}

	/**
	 * Show the video admin panel
	 *
	 * @return Response
	 */
	public function index()
	{
		return view('tokens.list');
	}

	

}


