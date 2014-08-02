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

Route::get('/test', function() {
	$str = "/pokedex/squirtle";
	echo str_replace("/pokedex/", "", $str);
});