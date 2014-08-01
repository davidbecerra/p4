<?php

/*--------------------------------------------------------------------------------------------------
| Homepage
--------------------------------------------------------------------------------------------------*/
Route::get('/', 'HomeController@showWelcome');


/*-------------------------------------------------------------------------------------------------
| Search page for Pokemon
-------------------------------------------------------------------------------------------------*/
Route::get('/pokemon', 'PokemonController@getPokemon');
Route::post('/pokemon', 'PokemonController@postPokemon');

/*-------------------------------------------------------------------------------------------------
| Display page for particular Pokemon
-------------------------------------------------------------------------------------------------*/
Route::get('/pokemon/{nameURI}', 'PokemonController@displayPokemon');
	// $pokemon = Session::get('pokemon');
	// if (!$pokemon) {
	// 	try {
	// 		$pokemon = Pokemon::where('URI', '=', $nameURI)->firstOrFail();
	// 		$pokemon = $pokemon->jsonSerialize();
	// 	}
	// 	catch (Exception $e) {
	// 		throw $e;
	// 	}
	// }
	// echo "<img src=" . $pokemon['image'] . ">";
	// echo $pokemon['name'] . " found!";
// });

/*-------------------------------------------------------------------------------------------------
| Login Page
--------------------------------------------------------------------------------------------------*/
Route::get('/login', function() {
	echo "Coming soon!";
});




/*-------------------------------------------------------------------------------------------------
| Signup Page
--------------------------------------------------------------------------------------------------*/
Route::get('/signup', function() {
	echo "Coming soon!";
});



/*********************************************************************
* DELETE THE BELOW ROUTES ON LIVE SERVER
**********************************************************************/

Route::get('/scrape', 'ScraperController@getScrape');


/*-------------------------------------------------------------------------------------------------
// !Debug
-------------------------------------------------------------------------------------------------*/
Route::get('/debug', function() {

	echo '<pre>';

	echo '<h1>environment.php</h1>';
	$path = base_path().'/environment.php';

	try {
		$contents = 'Contents: '.File::getRequire($path);
		$exists = 'Yes';
	}
	catch (Exception $e) {
		$exists = 'No. Defaulting to `production`';
		$contents = '';
	}

	echo "Checking for: ".$path.'<br>';
	echo 'Exists: '.$exists.'<br>';
	echo $contents;
	echo '<br>';

	echo '<h1>Environment</h1>';
	echo App::environment().'</h1>';

	echo '<h1>Debugging?</h1>';
	if(Config::get('app.debug')) echo "Yes"; else echo "No";

	echo '<h1>Database Config</h1>';
	print_r(Config::get('database.connections.mysql'));

	echo '<h1>Test Database Connection</h1>';
	try {
		$results = DB::select('SHOW DATABASES;');
		echo '<strong style="background-color:green; padding:5px;">Connection confirmed</strong>';
		echo "<br><br>Your Databases:<br><br>";
		print_r($results);
	}
	catch (Exception $e) {
		echo '<strong style="background-color:crimson; padding:5px;">Caught exception: ', $e->getMessage(), "</strong>\n";
	}

	echo '</pre>';

});

Route::get('/seed-orm', function() {
	# Clear the tables to a blank slate
	DB::statement('SET FOREIGN_KEY_CHECKS=0'); # Disable FK constraints so that all rows can be deleted, even if there's an associated FK
	DB::statement('TRUNCATE pokemon');
	DB::statement('TRUNCATE types');
	DB::statement('TRUNCATE moves');
	DB::statement('TRUNCATE abilities');
	DB::statement('TRUNCATE move_pokemon');
	DB::statement('TRUNCATE pokemon_type');
	DB::statement('TRUNCATE ability_pokemon');

	# Pokemon
	$squirtle = new Pokemon;
	$squirtle->name = 'Squirtle';
	$squirtle->index = 7;
	$squirtle->image = 'http://img.pokemondb.net/artwork/squirtle.jpg';
	$squirtle->URI = 'squirtle';
	$squirtle->save();

	$mr_mime = new Pokemon;
	$mr_mime->name = 'Mr. Mime';
	$mr_mime->index = 122;
	$mr_mime->image = 'http://img.pokemondb.net/artwork/mr-mime.jpg';
	$mr_mime->URI = 'mr-mime';
	$mr_mime->save();

	# Types
	$water   = Type::create(array('name' => 'Water'));
	$psychic = Type::create(array('name' => 'Psychic'));
	$fairy   = Type::create(array('name' => 'Fairy'));

	# Moves
	$bubble = new Move;
	$bubble->name = 'Bubble';
	$bubble->power = 40;
	$bubble->category = 'special';
	$bubble->accuracy = '100';
	$bubble->PP = 25;
	$bubble->effect = 'Deals damage.';
	$bubble->type()->associate($water);
	$bubble->save();

	$squirtle->moves()->attach($bubble);
	$squirtle->type()->attach($water);
	$mr_mime->type()->attach($psychic);
	$mr_mime->type()->attach($fairy);

	echo "Done seeding DB; check DB for results!";
});
