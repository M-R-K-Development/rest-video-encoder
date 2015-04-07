<?php 
/**
* Services
* Deal with the user token
* @author  Gregoire Duché <greg.duche@mrkdevelopment.com>
* @copyright  M R K Development Pty Ltd.
* @license GNU GENERAL PUBLIC LICENSE
*/
namespace Rve\Http\Middleware;

use Closure;

class Services {

	/**
	 * Handle an incoming request and check that the user token has been given in the Request's headers
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next) {
		
		// Checking the X-Auth-Token parameter from the header to see if the user is authenticated
		if (\Rve\Services\UserToken::checkAndAuthToken($request)) {
			return $next($request);	
      	} else {
      		//Authentication failed for some reason
      		$service = new \Rve\Http\Controllers\WebServices([]);

      		return $service->respondForbidden();
      	}
		
	}

}
