<!DOCTYPE html>
<html>

<head>

	<title>@yield('title', 'WebDex')</title>

	<link rel='stylesheet' type='text/css' href= {{ URL::asset('styles/master.css') }}>
	<link href={{ URL::asset('pokeball.ico') }} rel="shortcut icon" />
	@yield('head')

</head>

<body>
	<div class='header'>
		<div class='logo'>
		</div>
		<!-- <img src="http://fc00.deviantart.net/fs71/f/2012/102/f/1/pokeball_sprite_by_creepypasta81691-d4vzl6r.png" alt='Pokeball sprite'> -->
		<div class='player-sprite'>
			<img src="http://fc03.deviantart.net/fs70/f/2012/220/d/5/pokemon_yellow_character_and_pikachu_sprites_by_eri_tchi-d4moyx2.png" alt='Pokemon Trainer Sprite' id='pokemon-trainer'>
		</div>
	</div>
	@if(Session::get('flash_message'))
		<div class='flash-message'>{{ Session::get('flash_message') }}</div>
	@endif

	<div class='nav-bar'>
		<div class='main-nav'>
			<a href='/'>Home</a> |
			<a href='/pokemon'>Pokemon</a>
		</div>
		<div class='user-nav'>
			<a href='/login'>Login</a> |
			<a href='/signup'>Signup</a>
		</div>
	</div>

	<br>

	@yield('content')

	@yield('body')

</body>

</html>