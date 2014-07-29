<?php

class PokemonController extends BaseController {

	# Handler for queries that just involve searching for a single Pokemon via its name
	public function handle_name_query() {
		// Find query (checking query presence mostly as sanity check)
		if (Input::has('query')) {
			$input = Input::get('query');
			try {
				$pokemon = Pokemon::where('name', '=', $input)->firstOrFail();
				return Redirect::to('/pokemon' . $pokemon->URI)->with('name', $pokemon->name);
			} catch (Exception $e) {
				throw $e;
			}
		}
		else
			return View::make('pokemon');
	}
	
}