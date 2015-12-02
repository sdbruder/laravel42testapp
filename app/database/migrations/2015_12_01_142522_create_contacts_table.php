<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContactsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('contacts', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('user_id')->unsigned()->references('id')->on('users')->onDelete('cascade');
			$table->string('name');
			$table->string('surname');
			$table->string('email');
			$table->string('phone');
			$table->string('field1');
			$table->string('field2');
			$table->string('field3');
			$table->string('field4');
			$table->string('field5');
			$table->timestamps();
		});

		DB::statement('ALTER TABLE contacts ADD FULLTEXT full (name, surname, email, phone, field1, field2, field3, field4, field5)');
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('contacts', function($table) {
			$table->dropIndex('full');
		});
		Schema::drop('contacts');
	}

}
