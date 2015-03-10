<?php namespace Rve\Http\Controllers\API\RVE;

use Rve\Http\Requests;
use Rve\Http\Controllers\Controller;

use Illuminate\Http\Request;

class VideoFiles extends \Rve\Http\Controllers\API\API {

	protected $name = 'Video Files';
	protected $apiPrefix = 'api/rve/';


	/**
	 * Setting up the transformer to be a VideoFile Transformer
	 * @param Request object self injected
	 */
	public function __construct(Request $request) {
		$this->transformer = new \Rve\Http\Transformers\VideoFile;
		parent::__construct($request);
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
