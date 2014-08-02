<?php

class TypeSeeder extends Seeder {

	public function run() {

		# Clear the tables to a blank slate
		DB::statement('SET FOREIGN_KEY_CHECKS = 0');
		DB::statement('TRUNCATE types');

		# Load types and store in Type database
		$json = json_decode(file_get_contents(app_path() . '/database/seeds/types.json'), true);
		foreach ($json['types'] as $type) {
			$new_row = Type::create(array('name' => $type));
			$new_row->save();
		}

	}
}