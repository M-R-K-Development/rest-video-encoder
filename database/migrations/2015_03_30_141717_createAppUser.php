<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppUser extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		$user                        = new \Rve\Models\User;
        $user->email                 = 'email@domain.com';
        $user->password              = 'dqX43VrV';
        
        if (! $user->save()) {
            echo "Error creating user";
        } else {
        }
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//
	}

}