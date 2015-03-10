<?php
namespace Rve\Http\Controllers\API;

use Rve\Http\Requests;
use Rve\Http\Controllers\Controller;

use Illuminate\Http\Request;

class API extends \Rve\Http\Controllers\WebServices\WebServices {


	protected $name = 'API';
	protected $apiPrefix = 'api/';
	protected $transformer;

	public function __construct(Request $request) {

		$this->middleware('services');

		
		$routeResolver = $request->getRouteResolver();
		$route = $routeResolver();
		$action = $route->getAction();

		$prefix = $action['prefix'];
		$version = substr($prefix, strlen($this->apiPrefix) + 1, strlen($prefix));
		
		$service = array('name' => $this->name, 'version' => $version, 'url' => \URL::to($route->getUri()));
      	parent::__construct($service);
	}
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index($input = null)
	{
		// Input is being passed as a parameter so that we can mock it easily for the tests
		// If it is not a test, we'll use the facade:
		if (!$input) {
			$input == \Input::all();
		}

		$records = $this->getRecords($input);

	    $data = \Rve\Models\VideoFiles::search()->paginate($records);

	    $collection = $this->getResourceCollectionWithPagination($data, $this->transformer);

	    return $this->respondOK($collection);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
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

