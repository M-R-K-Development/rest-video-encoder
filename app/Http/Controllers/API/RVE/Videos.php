<?php 
/**
* Video  service
* Method for Video via API
* @author  Gregoire Duché <greg.duche@mrkdevelopment.com>
* @copyright  M R K Development Pty Ltd.
* @license GNU GENERAL PUBLIC LICENSE
*/
namespace Rve\Http\Controllers\API\RVE;

use Rve\Http\Requests;
use Rve\Http\Controllers\Controller;

use Illuminate\Http\Request;

/**
* Video service
* Method for Video via API 
*/
class Videos extends \Rve\Http\Controllers\API\API {
	/**
	 * Service name
	 * @var string
	 */
	protected $name = 'Videos';

	/**
	 * API Prefix for version in service response
	 * @var string
	 */
	protected $apiPrefix = 'api/rve/';

	/**
	 * Setting up the transformer to be a VideoFile Transformer
	 * @param Request object self injected
	 */
	public function __construct(Request $request) {
		$this->transformer = new \Rve\Http\Transformers\Video;
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

	    $data = \Rve\Models\Video::search()->paginate($records);

	    $collection = $this->getResourceCollectionWithPagination($data, $this->transformer);

	    return $this->respondOK($collection);
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
		$input = \Input::json()->all();
		
        $video = \Rve\Models\Video::create($input);

        if (!$video->validationErrors->isEmpty()) {
            return $this->respondValidationErrors($video->validationErrors->all());
        }

        return $this->respondCreated(['id' => $video->id]);
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
