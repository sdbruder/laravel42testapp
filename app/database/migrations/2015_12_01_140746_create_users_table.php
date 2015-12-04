<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('email');
			$table->string('provider');
			$table->string('provider_id');
			$table->string('token')->unique()->nullable();
			$table->string('token_secret')->nullable();
			$table->string('password', 60)->nullable();
			$table->rememberToken();
			$table->timestamps();
			$table->unique(['provider', 'provider_id']);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('users');
	}

}
