<?php 
/**
* File transformer
* User to format a video file
* @author  Gregoire Duché <greg.duche@mrkdevelopment.com>
* @copyright  M R K Development Pty Ltd.
* @license GNU GENERAL PUBLIC LICENSE
*/
namespace Rve\Http\Transformers;

/**
* Video transformer
* Extends the Transformer to format a video file
*/
class File extends \Rve\Http\Transformers\Transformer {
  	protected $mapping = [
  		'status'           => 'status',
		'original_filename' => 'original_filename',
		'filename'          => 'filename',
		'path'  => 'path',
		'id' => 'id|integer',
		'type' => 'type',
		'created_at' => 'create_at|date',
		'links' => 'links|json'
  	];
}
