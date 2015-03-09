<?php namespace Rve\Http\Middleware;

use Closure;

class RefreshToken {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		
		if (\Auth::check()) {
			$user = \Auth::user();
			\Rve\Services\UserToken::refreshToken($user);
		}
		return $next($request);
	}

}
