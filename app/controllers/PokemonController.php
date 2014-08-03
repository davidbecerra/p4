<?php

class PokemonController extends BaseController {

	# Going to '/pokemon' page
	public function getPokemon() {
		# Populate advance search with all the possible Pokemon types
		$types = Type::all();
		$output = '<ul class="type-list">';
		foreach ($types as $type) {
			$output .= "<li><span class='type-container background-color-" . strtolower($type->name) . "'>$type->name</span>";
			$name = strtolower($type->name);
			$output .= "<input type='checkbox' value=$name name=$name></li>";
		}
		$output .= '</ul>';
		Return View::make('pokemon_index')->with('output', $output);
	}

	# Handler for queries that just involve searching for a single Pokemon via its name
	public function postPokemon() {

		$input = Input::except('_token');
		if ($input) {
			# Try to search for query in pokemon table.
			try {
				$type = Type::where('name', '=', array_pop($input))->with('pokemon')->firstOrFail();
			} 
			catch (Exception $e) { # No query found
				return Redirect::to('/pokemon')->with('flash_message', 'No results found');
			}
			# Query found
			
			// return Redirect::to('/pokemon/' . $pokemon->URI)->with('pokemon', $pokemon);
		}
		// No input provided (which should never happen via post, but just in case...)
		else
			return $this->getPokemon();
	}

	public function displayPokemon($nameURI) {
		# Get pokemon query collection (or grab query from database if none in Session)
		$pokemon = Session::get('pokemon');
		if (!$pokemon) {
			try {
				$pokemon = Pokemon::where('URI', '=', $nameURI)->firstOrFail();
			}
			catch (Exception $e) { // Page not found (someone type URI of invalid pokemon)
				throw $e;
			}
		}
		$name = $pokemon->name;
		$content = "<img src=".$pokemon->image."><br><br>";
		$content .= "<h1>#" . $pokemon->index . " " . $pokemon->name . "</h1>";
		$content .= "<b>Weight</b>: $pokemon->weight<br>";
		$content .= "<b>Height</b>: $pokemon->height<br><br>";
		$moves = '';
		foreach ($pokemon->moves as $move) {
			$level = $move->pivot->level;
			$content .= "$level | $move->name | $move->power | $move->accuracy | $move->PP | $move->effect<br>";
		}
		$output = array('name' => $name, 'content' => $content);
		return View::make('pokemon_display')->with('output', $output);
	}
	
}