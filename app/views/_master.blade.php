<!DOCTYPE html>
<html>

<head>

	<title>@yield('title', 'WebDex')</title>

	<link rel='stylesheet' type='text/css' href='styles/master.css'>

	@yield('head')

</head>

<body>

	<div class='nav-bar'>
		<a href='/'>Home</a>
		<a href='/login'>Login</a> |
		<a href='/signup'>Signup</a>
	</div>

	@yield('content')

	@yield('body')

</body>

</html>