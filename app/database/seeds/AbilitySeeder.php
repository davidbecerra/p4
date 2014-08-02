<?php

class AbilitySeeder extends Seeder {

	public function run() {
		# Clear the tables
		DB::statement('SET FOREIGN_KEY_CHECKS = 0');
		DB::statement('TRUNCATE abilities');

		# Load the abilities and store in Ability database
		$json = json_decode(file_get_contents(app_path() . '/database/seeds/abilities.json'), true);
		foreach ($json as $ability) {
			$new_ability = Ability::create($ability);
			$new_ability->save();
		}	
	}
	
}