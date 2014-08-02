<?php

class MoveSeeder extends Seeder {

	# Seeds moves database with json data from 'moves.json' file
	public function run() {

		# Clear the tables to a blank slate
		DB::statement('SET FOREIGN_KEY_CHECKS = 0');
		DB::statement('TRUNCATE moves');

		# Load moves and store in Move database
		$json = json_decode(file_get_contents(app_path() . '/database/seeds/moves.json'), true);
		foreach ($json as $move) {
			$new_move = new Move;
			$new_move->name = $move['name'];

			# If no power ('-'), set to -1
			if ($move['power'] == '-')
				$new_move->power = -1;
			else				
				$new_move->power = (int) $move['power'];

			# If no accuracy ('-') set to -1. If infinite accuracy, set to -2
			if ($move['accuracy'] == '-')
				$new_move->accuracy = -1;
			elseif ($move['accuracy'] == '&infin')
				$new_move->accuracy = -2;
			else
				$new_move->accuracy = (int) $move['accuracy'];

			$new_move->PP = $move['PP'];
			$new_move->category = $move['category'];
			$new_move->effect = $move['effect'];
			$new_move->target = $move['target'];

			# Attach type_id foreign key
			try {
				$type = Type::where('name', '=', $move['type'])->firstOrFail();
				$new_move->type()->associate($type);
			}
			catch (Exception $e) {
			}

			# Save to database
			$new_move->save();
		}
	}
}