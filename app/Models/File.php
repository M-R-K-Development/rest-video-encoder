<?php namespace Rve\Models;

use Illuminate\Database\Eloquent\Model;

class File extends BaseModel {

	public $table = 'files';

    //use SoftDeletingTrait;

    public static $rules = [
        'user_id' => 'required'
    ];

    public $fillable = ['path', 'user_id', 'status', 'size', 'resolvable_type', 'resolvable_id', 'original_filename', 'type', 'links'];

}

    