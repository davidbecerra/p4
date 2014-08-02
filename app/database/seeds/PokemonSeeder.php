<?php

class PokemonSeeder extends Seeder {

	public function run() {
		# Clear the tables
		DB::statement('SET FOREIGN_KEY_CHECKS = 0');
		DB::statement('TRUNCATE pokemon');
	
		# Load pokemon data and store each pokemon into database
		$json = json_decode(file_get_contents(app_path() . '/database/seeds/pokemon.json'), true);
		foreach ($json as $pokemon) {
			# Create row for this pokemon
			$new_pokemon = new Pokemon;
			$new_pokemon->name = $pokemon['name'];
			$new_pokemon->index = (int) $pokemon['index'];
			$new_pokemon->image = $pokemon['image'];
			$new_pokemon->URI = $pokemon['URI'];
			$new_pokemon->height = $pokemon['height'];
			$new_pokemon->weight = $pokemon['weight'];
			$new_pokemon->save();
			# Link with pivot tables
				# Setup type relationship
			foreach ($pokemon['type'] as $type_query) {
				try {
					$type = Type::where('name', '=', $type_query)->firstOrFail();
					$new_pokemon->types()->attach($type);
				}
				catch (Exception $e) {}
			}	
				# Setup ability relationship
			foreach ($pokemon['ability'] as $ability_query) {
				try {
					$ability = Ability::where('name', '=', $ability_query)->firstOrFail();
					$new_pokemon->abilities()->attach($ability);
				} 
				catch (Exception $e) {}
			}
				# Setup move relationship. (NOTE: this pivot table has a third field; level)
			foreach ($pokemon['moves'] as $move_query) {
				try {
					$move = Move::where('name', '=', $move_query['move_name'])->firstOrFail();
					$new_pokemon->moves()->attach($move, array('level' => $move_query['level']));
				}
				catch (Exception $e) {}
			}
		}
	}
}