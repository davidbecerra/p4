<?php

class PokemonController extends BaseController {

	# Helper function for getPokemon(). Retrieves a list of all the types in database
	private function getTypes() {
		# Create a nice HTML list of all types
		$types = Type::all();
		$output = '<ul class="type-list">';
		foreach ($types as $type) {
			$output .= "<li class='type-list'><span class='type-container background-color-" . strtolower($type->name) . "'>$type->name</span>";
			$name = strtolower($type->name);
			$output .= "<input type='checkbox' value=$name name=$name></li>";
		}
		$output .= '</ul>';
		return $output;
	}

	# Going to '/pokemon' page
	public function getPokemon() {
		$output = $this->getTypes();
		Return View::make('pokemon_index')->with('output', $output);
	}

	# Handler for queries that just involve searching for a single Pokemon via its name
	public function postPokemon() {

		$input = Input::except('_token');
		if ($input) {
			# Search for query in pokemon table.
			$pokemon_list = new Pokemon;
			foreach ($input as $type) {
				$pokemon_list = $pokemon_list->whereHas('types', function($query) use ($type) {
					$query->where('name', '=', $type);
				});
			}
			$pokemon_list = $pokemon_list->get();
			
			# If no results found, return to page
				if ($pokemon_list->isEmpty())
					return Redirect::to('/pokemon')->with('flash_message', 'No results found');

			# Query found
			$query_results = '<ul>';
			$results_class = "class='results'";
			foreach ($pokemon_list as $pokemon) {
				$query_results .= "<li $results_class><a href=/pokemon/$pokemon->URI>";				
				$query_results .= "<img src=$pokemon->image $results_class>$pokemon->name</a></li>";
			}
			$query_results .= "</ul>";
			$view = $this->getPokemon();
			return $view->with('query_results', $query_results);
		}
		# No input provided (which should never happen via post, but just in case...)
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