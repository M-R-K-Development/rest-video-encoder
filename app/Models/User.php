<?php namespace Rve\Models;

use Illuminate\Database\Eloquent\Model;

class User extends BaseModel {

	public $table = 'users';

    //use SoftDeletingTrait;

    public static $rules = [
        
    ];

    public $fillable = ['name', 'email', 'password'];

}
