<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTables extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		# Create pokemon table
		Schema::create('pokemon', function($table) {
			# AI, PK
			$table->increments('id');

			# created_at, updated_at columns
			$table->timestamps();

			# General data..
			$table->string('name');
			$table->smallInteger('index')->unsigned();
			$table->string('image');
			$table->string('URI');
		});

		Schema::create('types', function($table) {
			# AI, PK
			$table->increments('id');

			# created_at, updated_at columns
			$table->timestamps();

			# General data...
			$table->string('name');
		});

		Schema::create('moves', function($table) {
			# AI, PK
			$table->increments('id');

			# created_at, updated_at columns
			$table->timestamps();

			# General data
			$table->string('name');
			$table->smallInteger('power')->unsigned();
			$table->smallInteger('accuracy')->unsigned();
			$table->tinyInteger('PP')->unsigned();
			$table->enum('category', array('special', 'physical'));
			$table->text('effect');

			# Define foreign key
			$table->integer('type_id')->unsigned(); 
			$table->foreign('type_id')->references('id')->on('types');
		});

		Schema::create('abilities', function($table) {
			# AI, PK
			$table->increments('id');

			# created_at, updated_at columns
			$table->timestamps();

			# General data...
			$table->string('name');
			$table->text('effect');
		});

		//----------------------------------------------------
		// Pivot tables
		//----------------------------------------------------

		Schema::create('move_pokemon', function($table) {
			# General data
			$table->tinyInteger('level')->unsigned();

			# Define foreign keys
			$table->integer('pokemon_id')->unsigned();
			$table->foreign('pokemon_id')->references('id')->on('pokemon');
			
			$table->integer('move_id')->unsigned();
			$table->foreign('move_id')->references('id')->on('moves');
		});

		Schema::create('pokemon_type', function($table) {
			# Define foreign keys
			$table->integer('pokemon_id')->unsigned();
			$table->foreign('pokemon_id')->references('id')->on('pokemon');

			$table->integer('type_id')->unsigned();
			$table->foreign('type_id')->references('id')->on('types');
		});

		Schema::create('ability_pokemon', function($table) {
			# Define foreign keys
			$table->integer('pokemon_id')->unsigned();
			$table->foreign('pokemon_id')->references('id')->on('pokemon');

			$table->integer('ability_id')->unsigned();
			$table->foreign('ability_id')->references('id')->on('abilities');
		});

	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		// Drop tables
		Schema::drop('move_pokemon');
		Schema::drop('pokemon_type');
		Schema::drop('ability_pokemon');
		Schema::drop('moves');
		Schema::drop('pokemon');
		Schema::drop('abilities');
		Schema::drop('types');
	}

}
