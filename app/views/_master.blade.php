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

		<div class='player-sprite'>
			<img src="http://fc03.deviantart.net/fs70/f/2012/220/d/5/pokemon_yellow_character_and_pikachu_sprites_by_eri_tchi-d4moyx2.png" alt='Pokemon Trainer Sprite' id='pokemon-trainer'>
		</div>
		
	</div>

	@if(Session::get('flash_message'))
		<div class='flash-message'>{{ Session::get('flash_message') }}</div>
	@endif

	<div class='nav-bar'>
		<ul class='main-nav'>
			<li class='nav'><a href='/' class='nav first'>Home</a></li>
			<li class='nav'><a href='/pokemon' class='nav'>Pok&eacute;mon</a></li>
		</ul>
	</div>

	<br><br>
	
	<div class='content-wrapper'>
		@yield('content')
	</div>
	@yield('body')

</body>

</html>