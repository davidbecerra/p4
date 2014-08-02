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
			$table->string('height');
			$table->string('weight');
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
			$table->smallInteger('power');
			$table->smallInteger('accuracy');
			$table->string('PP');
			$table->enum('category', array('special', 'physical', 'status'));
			$table->text('effect');
			$table->text('target');

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
		# Drop foreign keys
		Schema::table('moves', function($table) {
			$table->dropForeign('moves_type_id_foreign');
		});
		Schema::table('move_pokemon', function($table) {
			$table->dropForeign('move_pokemon_pokemon_id_foreign');
		});
		Schema::table('move_pokemon', function($table) {
			$table->dropForeign('move_pokemon_move_id_foreign');
		});
		Schema::table('pokemon_type', function($table) {
			$table->dropForeign('pokemon_type_pokemon_id_foreign');
		});
		Schema::table('pokemon_type', function($table) {
			$table->dropForeign('pokemon_type_type_id_foreign');
		});
		Schema::table('ability_pokemon', function($table) {
			$table->dropForeign('ability_pokemon_pokemon_id_foreign');
		});		
		Schema::table('ability_pokemon', function($table) {
			$table->dropForeign('ability_pokemon_ability_id_foreign');
		});

		# Drop tables
		Schema::drop('move_pokemon');
		Schema::drop('pokemon_type');
		Schema::drop('ability_pokemon');
		Schema::drop('moves');
		Schema::drop('pokemon');
		Schema::drop('abilities');
		Schema::drop('types');
	}

}
