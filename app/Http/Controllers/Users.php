<?php 
/**
* Users controller
* Users allowed to access the back end
* @author  Gregoire Duché <greg.duche@mrkdevelopment.com>
* @copyright  M R K Development Pty Ltd.
* @license GNU GENERAL PUBLIC LICENSE
*/ 
namespace Rve\Http\Controllers;
 
use Rve\Http\Controllers\Controller;

class Users extends Controller {
	
	/**
	 * Construct the class using the middleware Auth
	 */
	public function __construct() {
		$this->middleware('auth');
	}

	/**
	 * List all the users in the system
	 * @return String the HTML View
	 */
	public function index() {
		return \View::make('users.list');
	}

}
