<!DOCTYPE html>
<html>

<head>

	<title>@yield('title', 'WebDex')</title>

	<link rel='stylesheet' type='text/css' href='styles/master.css'>

	@yield('head')

</head>

<body>

	@if(Session::get('flash_message'))
		<div class='flash-message'>{{ Session::get('flash_message') }}</div>
	@endif

	<div class='nav-bar'>
		<div class='main-nav'>
			<a href='/'>Home</a>
		</div>
		<div class='user-nav'>
			<a href='/login'>Login</a> |
			<a href='/signup'>Signup</a>
		</div>
	</div>

	@yield('content')

	@yield('body')

</body>

</html>