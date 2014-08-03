<?php

class HomeController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	public function showWelcome()
	{
		return View::make('index');
	}

	# Handler for queries that just involve searching for a single Pokemon via its name
	public function postIndex() {
		$input = Input::get('query');
		if ($input) {
			# Try to search for query in pokemon table.
			try {
				$pokemon = Pokemon::where('name', '=', $input)->firstOrFail();
			} 
			# No Query found error
			catch (Exception $e) {
				return Redirect::to('/pokemon')->with('flash_message', 'No results found');
			}
			# Query found 
			return Redirect::to('/pokemon/' . $pokemon->URI)->with('pokemon', $pokemon);
		}
		# No input provided (which should never happen via post, but just in case...)
		else
			return View::make('index');
	}


}
