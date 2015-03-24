<?php 
/**
* UserToken transformer
* User to format a user token object
* @author  Gregoire Duché <greg.duche@mrkdevelopment.com>
* @copyright  M R K Development Pty Ltd.
* @license GNU GENERAL PUBLIC LICENSE
*/
namespace Rve\Http\Transformers;

/**
* User Token transformer
* Extends the Transformer to format a user token file
*/
class UserToken extends \Rve\Http\Transformers\Transformer {
  	protected $mapping = [
  		'id' => 'id|int',
  		'token' => 'token',
  		'application_id' => 'application_id'
  	];
}
