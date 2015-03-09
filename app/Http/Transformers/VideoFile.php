<?php
namespace Rve\Http\Transformers;

use League\Fractal;

class VideoFile extends Fractal\TransformerAbstract
{
    public function transform(\Rve\Models\VideoFiles $file)
    {
            return [
            	'id' => $file->id,
            	'path' => $file->path,
            	];
    }
}
