<?php 
/**
* API
* Defines common function for any services
* @author  Gregoire Duché <greg.duche@mrkdevelopment.com>
* @copyright  M R K Development Pty Ltd.
* @license GNU GENERAL PUBLIC LICENSE
*/
namespace Rve\Http\Controllers\API;

use Rve\Http\Requests;
use Rve\Http\Controllers\Controller;

use Illuminate\Http\Request;

/**
* API
* Defines common method for any services
*/
class API extends \Rve\Http\Controllers\WebServices\WebServices {


	protected $name = 'API';
	protected $apiPrefix = 'api/';
	protected $transformer;
	protected $tokenExemption = [];

	/**
	 * Instantiate the service with API version and URL
	 * @param Request $request self-injected Request object
	 */
	public function __construct(Request $request) {

		$this->middleware('services', ['except' => $this->tokenExemption]);
		
		$routeResolver = $request->getRouteResolver();
		$route = $routeResolver();
		$action = $route->getAction();

		$prefix = $action['prefix'];
		$version = substr($prefix, strlen($this->apiPrefix) + 1, strlen($prefix));
		
		$service = array('name' => $this->name, 'version' => $version, 'url' => \URL::to($route->getUri()));
      	parent::__construct($service);
	}
	
	

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create($input = null)
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store($input = null)
	{
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, $input = null)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, $input = null)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}

