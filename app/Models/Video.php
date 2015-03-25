<?php namespace Rve\Models;
use Illuminate\Database\Eloquent\Model;
use Rhumsaa\Uuid\Uuid;

class Video extends BaseModel {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'videos';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = array('id', 'uuid', 'title', 'description', 'enabled');

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = [];

	/**
	 * Adding a uuid self-generated on creationg
	 */
	public static function boot()
	{
		parent::boot();
		Video::creating(function ($video) {
			$video->uuid = Uuid::uuid4();
		});
	}

	public function file()
    {
        return $this->hasOne('Rve\Models\File');
    }

}