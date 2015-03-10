<?php namespace Rve\Models;

use Illuminate\Database\Eloquent\Model;

class File extends BaseModel {

	public $table = 'files';

    //use SoftDeletingTrait;

    public static $rules = [
        'user_id' => 'required'
    ];

    public $fillable = ['path', 'user_id', 'status', 'size', 'resolvable_type', 'resolvable_id', 'original_filename', 'type'];


    /*public static function boot() {
        File::creating(function ($file) {
            $file->uuid = Uuid::uuid4();

            if ($user = Auth::user()) {                
                $file->user_id = $user_id;
            }
        });
    }*/
    /*
     * gets the local location of the file.
     *
     * @return [type] [description]
     *
    public function getFilePath()
    {
        return storage_path('user-data/') . $this->path;
    }

    public function user()
    {
        return $this->belongsTo('User', 'user_id');
    }

    public static function boot()
    {
        parent::boot();

        \Imm\Files\Models\File::created(function ($file) {
            if (!is_null($file->resolvable_type) && ($file->resolvable_id > 0)) {
                \Event::fire('imm.file.uploaded', [ $file ] );
            }
        });
    }*/

}

    