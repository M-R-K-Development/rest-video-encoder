<?php 
/**
* Files
* Handles the file creation via the API
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
class Files extends \Rve\Http\Controllers\API\API {
	/**
	 * Service name
	 * @var string
	 */
	protected $name = 'Files';

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
		$this->transformer = new \Rve\Http\Transformers\File;
		parent::__construct($request);
	}

	public function index() {
		return $this->respond([]);
	}

	/**
	 * Store method used to upload a file chunk by chunk
	 *
	 * @return json the result of the upload
	 */
	public function store($input = null) {
		
		if (!$input == null) {
			$input = \Input::json();	
		}

		$user = \Auth::user();
		$input['user_id'] = $user->id;

		$validator = \Validator::make(
			$input,
			\Rve\Models\File::$rules
		);
		if ($validator->fails()) {
			return Response::make('Validation issues', 500);
		}

		$filename                   = time() . \Input::get('flowFilename');
		$input['original_filename'] = \Input::get('flowFilename');
		$extension                  = pathinfo($filename, PATHINFO_EXTENSION);
		$filename                   = pathinfo($filename, PATHINFO_FILENAME);

		if (!isset($input['path'])) {
			$input['path'] = $user->username . '/';
		} else {
			// $input['path'] = $input['path'] . '/' .$user->username .'/';
		}
		$storageLocation = storage_path('user-data/' . $input['path']);

		if (!is_dir($storageLocation)) {
			mkdir($storageLocation, 0755, true);
		}

		$config = new \Flow\Config();

		if (!is_dir($storageLocation . 'chunks')) {
			mkdir($storageLocation . 'chunks', 0755, true);
		}

		$config->setTempDir($storageLocation . 'chunks');
		$file = new \Flow\File($config);

		if (isset($_POST['ie-app'])) {
			$file->saveChunk();
		} else {

			if ($file->validateChunk()) {
				$file->saveChunk();
			} else {
				// error, invalid chunk upload request, retry
				return \Response::make('Bad request', 400);
			}
		}

		$filename  = \Rve\Services\Helpers::sanitizeString($filename) . '.' . $extension;

		$localPath = $storageLocation . $filename;
		if ($file->validateFile() && $file->save($localPath)) {
			$input['status'] = 'saved';
			$input['size']   = \Input::get('flowTotalSize');

			if (isset($_POST['ie-app'])) {
				$input['size'] = filesize($localPath);
			} else {
				$input['size'] = \Input::get('flowTotalSize');
			}
			$input['path'] = $input['path'] . $filename;
			$input['type'] = mime_content_type($localPath);

			$file = \Rve\Models\File::create($input);

			$response = \Event::fire(new \Rve\Events\VideoUpload($file));

			return $this->respondCreated(['id' => $file->id, 'path' => $file->path]);
		} else {
			// This is not a final chunk, continue to upload
			return \Response::JSON(array('pending' => true));
		}
	}
}
