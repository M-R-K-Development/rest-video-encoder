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

	/**
     * List all the includes name available
     * @var Array
     */
    protected $availableIncludes = [
    	'file'
    ];


  	protected $mapping = [
  		'id' => 'id|int',
  		'path' => 'path',
  		'title' => 'title',
  		'description' => 'description',
  	];


  	 public function includeFile(\Rve\Models\Video $video)
    {
        $file = $video->file;
        
        return $this->item($file, new File);
    }
}
