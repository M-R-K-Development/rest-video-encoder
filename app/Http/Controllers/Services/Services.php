<?php /**
* Services class - defining a generic class for all services
*/
namespace Rve\Http\Controllers\Services;

use Rve\Http\Controllers\Controller;
use \League\Fractal\Pagination\IlluminatePaginatorAdapter;

/**
* Generic class Services
*/
class Services extends Controller {

	private $service;
    protected $statusCode = 200;
    protected $transformer, $fractal, $defaultRecord;

    /**
    * __construct Instanciate a new Service
    * @param array $service the service's parameters
    */
	public function __construct($service)
	{
		$this->service = $service;
        $this->fractal = new \League\Fractal\Manager();

        if (isset($_GET['include'])) {
            $this->fractal->parseIncludes($_GET['include']);
        }
	}

    /**
    * getRecords - get the number of elements to display in the service response
    * @param array $input the parameters given to the Service function
    * @return int $records the number of elements to display
    */
    public function getRecords($input = []) {
        $records = $this->defaultRecord;
        if (isset($input['records'])) {
            $records = $input['records'];
        } 

        return $records;
    }


    protected function send($someData, $headers = [])
    {
        $token = Session::get('token');
        $result = array('token' => $token, 'service' => $this->service, 'data' => $someData);

        $this->_setCorsHeaders($headers);

        return \Response::json($result, $this->getStatusCode(),
            $headers);
    }

    /**
    * [setStatusCode description]
    *
    * @param [type] $code [description]
    */
    public function setStatusCode($code)
    {
        $this->statusCode = $code;

        return $this;
    }

    /**
     * [getStatusCode description]
     *
     * @return [type] [description]
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * Resource OK resource
     *
     * @param [type] $resource [description]
     *
     * @return [type] [description]
     */
    public function respondOK($resource, $headers = [])
    {
        $data = $this->fractal->createData($resource)->toArray();

        return $this->setStatusCode(200)->respond($this->_getOkResponse($data), $headers);
    }

    /**
     * resource creation wrapper response.
     *
     * @param [type] $data [description]
     *
     * @return [type] [description]
     */
    public function respondCreated($data)
    {
        return $this->setStatusCode(201)->respond($this->_getOkResponse($data));
    }

    /**
     * Not found wrapper response
     *
     * @param [type] $message [description]
     *
     * @return [type] [description]
     */
    public function respondNotFound($message, $headers = [])
    {
        return $this->setStatusCode(404)
                    ->respond(['error' => $message], $headers);
    }

    /**
     * Validation errors response.
     *
     * @param [type] $errors [description]
     *
     * @return [type] [description]
     */
    public function respondValidationErrors($errors)
    {
        return $this->setStatusCode(422)
                    ->respond(['errors' => $errors]);
    }

    public function respondWithError($error, $headers = [])
    {
        $this->_setCorsHeaders($headers);

        return Response::json(
            ['error' => $error],
            $this->getStatusCode(),
            $headers
        );
    }

    /**
     * General respond method.
     *
     * @param [type] $data    [description]
     * @param [type] $headers [description]
     *
     * @return [type] [description]
     */
    public function respond($data, $headers = [])
    {
        $this->_setCorsHeaders($headers);

        $data['token'] = $this->getToken();

        return \Response::json(
                    $data,
                    $this->getStatusCode(),
                    $headers
                );
    }

    public function getToken()
    {
        return \Rve\Services\UserToken::getToken();
    }

    /**
     * Helper method for OK - 200 responses.
     *
     * @param [type] $data [description]
     *
     * @return [type] [description]
     */
    private function _getOkResponse($data)
    {
        return array_merge(
                [
                    'service' => $this->service,
                ],
                $data);
    }

    /**
     * Computes the response data for a collection.
     *
     * @param [type] $paginator  [description]
     * @param [type] $tranformer [description]
     *
     * @return [type] [description]
     */
    public function getResourceCollectionWithPagination($paginator, $tranformer)
    {
        $resource = $this->getResourceCollection($paginator->getCollection(), $tranformer);
        $resource->setPaginator(new IlluminatePaginatorAdapter($paginator));

        return $resource;

    }

    /**
     * [getResourceCollection description]
     *
     * @param [type] $collection [description]
     * @param [type] $tranformer [description]
     *
     * @return [type] [description]
     */
    public function getResourceCollection($collection, $tranformer)
    {
        return  new \League\Fractal\Resource\Collection($collection, $tranformer);
    }

    /**
     * Response data for a single item. /show
     *
     * @param [type] $item       [description]
     * @param [type] $tranformer [description]
     *
     * @return [type] [description]
     */
    public function getResourceItem($item, $tranformer)
    {
        return new  League\Fractal\Resource\Item($item, $tranformer);
    }

    private function _setCorsHeaders(&$headers)
    {
        $headers['Access-Control-Allow-Origin'] = '*';
        $headers['Access-Control-Allow-Methods'] = 'GET, POST, OPTIONS';
        $headers['Access-Control-Allow-Headers'] = 'Origin, X-Requested-With, Content-Type, Accept, X-Auth-Token';
    }

}
