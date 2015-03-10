<?php
namespace Rve\Http\Controllers\API\RVE;

use Rve\Http\Requests;
use Rve\Http\Controllers\Controller;

use Illuminate\Http\Request;

class Files extends \Rve\Http\Controllers\API\API {
	
	/**
	 * Setting up the transformer to be a VideoFile Transformer
	 * @param Request object self injected
	 */
	public function __construct(Request $request) {
		//FIXME - wrogn transformer
		$this->transformer = new \Rve\Http\Transformers\VideoFile;
		parent::__construct($request);
	}

	/**
	 * Get given Group resource
	 *
	 * @param [type] $id [description]
	 *
	 * @return [type] [description]
	 */
	public function show($id) {
	}

	/**
	 * Store method.
	 *
	 * @return [type] [description]
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
				return Response::make('Bad request', 400);
			}
		}

		//FIXME :: $filename  = \Imm\Helpers\Sanitize::string($filename) . '.' . $extension;

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

			$immFile = \Rve\Models\File::create($input);

			return json_encode([
				'success'           => true,
				'original_filename' => \Input::get('flowFilename'),
				'filename'          => $filename,
				'path'              => $input['path'],
				'id'                => $immFile->id,
				'type'              => $input['type'],
				'created_at'        => $immFile->created_at->toFormattedDateString(),
			]);
		} else {
			// This is not a final chunk, continue to upload
			return Response::JSON(array('pending' => true));
		}
	}
}
