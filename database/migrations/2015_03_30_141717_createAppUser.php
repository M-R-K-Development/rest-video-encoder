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
		$user                        = new User;
        $user->email                 = 'email@domain.com';
        $user->password              = 'dqX43VrV';
        $user->password_confirmation = 'dqX43VrV';
        $user->confirmation_code     = md5(uniqid(mt_rand(), true));
        $user->confirmed             = 1;

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