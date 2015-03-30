<?php 
/**
* Users
* Deal with users
* @author  Gregoire Duché <greg.duche@mrkdevelopment.com>
* @copyright  M R K Development Pty Ltd.
* @license GNU GENERAL PUBLIC LICENSE
*/
namespace Rve\Http\Controllers\API\RVE;

use Rve\Http\Requests;
use Rve\Http\Controllers\Controller;

use Illuminate\Http\Request;

class Users extends \Rve\Http\Controllers\API\API {
	
	public function __construct(Request $request) {
		$this->transformer = new \Rve\Http\Transformers\User;
		parent::__construct($request);
	}

	/**
	 * Get all the tokens - not allowed without parameters,
	 * @return [type] [description]
	 */
	public function index($input = null) {
		
		
		// Input is being passed as a parameter so that we can mock it easily for the tests
		// If it is not a test, we'll use the facade:
		if (!$input) {
			$input = \Input::all();
		}

		$records = $this->getRecords($input);

	    $data = \Rve\Models\User::search()->paginate($records);

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
		
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store($input = null)
	{
		if (!$input) {
			$input = \Input::all();
		}

		$registrar = new \Rve\Services\Registrar;
		$validation = $registrar->validator($input);
		if ($validation->fails()) {
			return $this->respondValidationErrors($validation->errors());
		}
		$user = $registrar->create($input);
		return $this->respondCreated(['id' => $user->id]);
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
		$user = \Rve\Models\User::find($id);
        if (!$user) {
            return $this->respondNotFound("Resource not found");
        }

        $user->delete();
        $message = array('deleted'=>'ok');

        return $this->setStatusCode(200)->respond($message);
	}
}
