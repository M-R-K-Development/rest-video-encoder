<?php 
/**
* Transformer
* Generic class used to format a file
* @author  Gregoire Duché <greg.duche@mrkdevelopment.com>
* @copyright  M R K Development Pty Ltd.
* @license GNU GENERAL PUBLIC LICENSE
*/
namespace Rve\Http\Transformers;

use League\Fractal;

class Transformer extends Fractal\TransformerAbstract
{	
	/**
	 * Mapping to format the model's fields
	 * @var array attribute name => attribute | type
	 */
	protected $mapping = ['id' => 'id|integer'];

	public function transform(\Rve\Models\BaseModel $model)
    {
    		$formattedFields = [];
    		foreach ($this->mapping as $attributeName => $propertiesString) {
    			$properties = explode('|', $propertiesString);
    			$value = $model->$properties[0];

    			if (isset($properties[1])) {
    				switch ($properties[1]) {
    					case 'integer' : 
    						$value = (int) $value;
    					break;
                        case 'date' :
                           if ($value instanceof \Carbon\Carbon) {
                                $value = $value->toFormattedDateString();
                           } 
                        break;
    				}
    			}
    			$formattedFields[$attributeName] = $value;
    		}
    		
            return $formattedFields;
    }
}
