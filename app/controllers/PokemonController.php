<?php

class PokemonController extends BaseController {

	public function getPokemon() {
		Return View::make('pokemon_index');
	}

	# Handler for queries that just involve searching for a single Pokemon via its name
	public function postPokemon() {

		$input = Input::get('query');

		if ($input) {
			// Try to search for query in pokemon table.
			try {
				$pokemon = Pokemon::where('name', '=', $input)->firstOrFail();
			} 
			catch (Exception $e) { // No query found
				return Redirect::to('/pokemon')->with('flash_message', 'No results found');
			}
			// Query found 
			return Redirect::to('/pokemon/' . $pokemon->URI)->with('pokemon', $pokemon->jsonSerialize());
		}
		// No input provided (which should never happen via post, but just in case...)
		else
			return View::make('pokemon_index');
	}

	public function displayPokemon() {

	}
	
}