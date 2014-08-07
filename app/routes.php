<?php

/*--------------------------------------------------------------------------------------------------
| Homepage
--------------------------------------------------------------------------------------------------*/
Route::get('/', 'HomeController@showWelcome');
Route::post('/', 'HomeController@postIndex');


/*-------------------------------------------------------------------------------------------------
| Search page for Pokemon
-------------------------------------------------------------------------------------------------*/
Route::get('/pokemon', 'PokemonController@getPokemon');
Route::post('/pokemon', 'PokemonController@postPokemon');

/*-------------------------------------------------------------------------------------------------
| Display page for particular Pokemon
-------------------------------------------------------------------------------------------------*/
Route::get('/pokemon/{nameURI}', 'PokemonController@displayPokemon');

/*-------------------------------------------------------------------------------------------------
| Login Page
--------------------------------------------------------------------------------------------------*/
Route::get('/login', array(
	'before' => 'guest',
	function() {
		return View::make('login');
	})
);

Route::post('/login', array(
	'before' => 'csrf',
	function() {
		$credentials = Input::only('email', 'password');

		if (Auth::attempt($credentials, $remember = true)) {
			return Redirect::intended('/')->with('flash_message', 'Welcome back!');
		}
		else {
			return Redirect::to('/login')->with('flash_message', 'Log in failed; please try again');
		}

		return Redirect::to('/login');
	})
);

Route::get('/logout', function() {

    # Log out
    Auth::logout();

    # Send them to the homepage
    return Redirect::to('/');

});


/*-------------------------------------------------------------------------------------------------
| Signup Page
--------------------------------------------------------------------------------------------------*/
Route::get('/signup', array (
	'before' => 'guest', 
	function() {
		return View::make('signup');
	})
);	

Route::post('/signup', array( 
	'before' => 'csrf',
	function() {
		$user = new User;
		$user->username = Input::get('username');
		$user->email = Input::get('email');
		$user->password = Hash::make(Input::get('password'));

		# Try to add the user
		try {
			$user->save();
		}
		# Fail
		catch (Exception $e) {
			return Redirect::to('/signup')->with('flash_message', 'Sign up failed; please try again.');
		}

		# Log the user in
		Auth::login($user);

		return Redirect::to('/')->with('flash_message', 'Welcome!');
	})
);



/*********************************************************************
* DELETE THE BELOW ROUTES ON LIVE SERVER
**********************************************************************/

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