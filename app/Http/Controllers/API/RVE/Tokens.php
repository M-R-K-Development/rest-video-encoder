<?php 
/**
* Token
* Deal with user token API operations
* @author  Gregoire Duché <greg.duche@mrkdevelopment.com>
* @copyright  M R K Development Pty Ltd.
* @license GNU GENERAL PUBLIC LICENSE
*/
namespace Rve\Http\Controllers\API\RVE;

use Rve\Http\Requests;
use Rve\Http\Controllers\Controller;

use Illuminate\Http\Request;

/**
 * Files - handling the creation of files via the api 
 */
class Tokens extends \Rve\Http\Controllers\API\API {
	
	protected $tokenExemption = ['cors'];

	public function __construct(Request $request) {
		$this->transformer = new \Rve\Http\Transformers\UserToken;
		parent::__construct($request);
	}

	/**
	 * Respond OK if the user have a correct token
	 * @return JSON the respond
	 */
	public function handshake() {
		return $this->respond([]);
	}

	/**
	 * Respond OK if the user have a correct token
	 * @return JSON the respond
	 */
	public function cors() {
		return $this->respond([]);
	}


	/**
	 * Get all the tokens - not allowed without parameters,
	 * @return [type] [description]
	 */
	public function index($input = null) {
		if (!$input) {
			$input == \Input::all();
		}

		if (\Auth::check()) {
            $user = \Auth::user();
            $user_id = $user->id;
			
			$records = $this->getRecords($input);

	    	$tokens = \Rve\Models\UserToken::where('user_id', '=', $user_id)->whereNotNull('application_id')->paginate();

	    	$collection = $this->getResourceCollectionWithPagination($tokens, $this->transformer);

	    	return $this->respondOK($collection);
        } else {
        	return $this->respondNotFound('Forbidden - specify user id');
        }
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
			$input == \Input::all();
		}

		$application_id = \Input::get('application_id');
		if (!$application_id) {
			return $this->respondNotFound('Forbidden - specify application id');
		}

		if (\Auth::check()) {
            $user = \Auth::user();
            $application_id = \Input::get('application_id');

			$token = \Rve\Services\UserToken::generateNewToken($user, $application_id);
			return $this->respondCreated(['token' => $token]);
        } else {
        	return $this->respondNotFound('Forbidden - specify user id');
        }
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
		$token = \Rve\Models\UserToken::find($id);
        if (!$token) {
            return $this->respondNotFound("Resource not found");
        }

        $token->delete();
        $message = array('deleted'=>'ok');

        return $this->setStatusCode(200)->respond($message);
	}
}
