<?php

class UserController extends BaseController {

	public function __construct() {
		# Make sure BaseController construct gets called
		parent::__construct();

		# Only guests have access to login and signup page
		$this->beforeFilter('guest', array('only' => array('getLogin', 'getSignup')));
	}

	/*-------------------------------------------------------------------------------------------------
	| Log in/Log out
	--------------------------------------------------------------------------------------------------*/
	public function getLogin() {
		return View::make('login');
	}

	public function postLogin() {
		# Get login information
		$credentials = Input::only('email', 'password');
		$remember = Input::get('remember', false);

		# Successful login
		if (Auth::attempt($credentials, (bool) $remember)) {
			return Redirect::intended('/')->with('flash_message', 'Welcome Back!');
		}
		# Login failed
		else {
			return Redirect::to('/login')
						->with('flash_message', 'Log in failed; please try again')
						->withInput();
		}

		return Redirect::to('/login');
	}

	public function getLogout() {
		# Log out
		Auth::logout();

		# Send them to the homepage
		return Redirect::to('/')->with('flash_message', 'Log out successful');
	}
	/*-------------------------------------------------------------------------------------------------
	| Sign up 
	--------------------------------------------------------------------------------------------------*/
	public function getSignup() {
		return View::make('signup');
	}

	public function postSignup() {

		# Define rules for validation and create validator
		$rules = array(
			'username' => 'Between:3,13|unique:users,username|alpha_dash|required',
			'email' => 'email|unique:users,email|required',
			'password' => 'Between:6,50|alpha_dash|required'
		);
		$validator = Validator::make(Input::all(), $rules);

		# Handle failed validation		
		if ($validator->fails()) {
			return Redirect::to('/signup')
						->with('flash_message', 'Sign up failed; please try again')
						->withInput()
						->withErrors($validator);
		}

		# Create new user
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
	}
}