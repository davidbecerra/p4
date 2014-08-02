<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

		$this->call('TypeSeeder');
		$this->call('MoveSeeder');
		$this->call('AbilitySeeder');
		$this->call('PokemonSeeder');
	}

}
