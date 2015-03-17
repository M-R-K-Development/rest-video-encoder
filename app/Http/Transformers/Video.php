<?php 
/**
* Video transformer
* User to format a video object
* @author  Gregoire Duché <greg.duche@mrkdevelopment.com>
* @copyright  M R K Development Pty Ltd.
* @license GNU GENERAL PUBLIC LICENSE
*/
namespace Rve\Http\Transformers;

/**
* Video transformer
* Extends the Transformer to format a video file
*/
class Video extends \Rve\Http\Transformers\Transformer {
  	protected $mapping = [
  		'id' => 'id|int',
  		'path' => 'path'
  	];
}
