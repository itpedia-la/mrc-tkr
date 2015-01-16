<?php

/**
 * User Controller
 * -------------------
 * @author Somwang
 *
 */
class UserController extends Controller {

	/**
	 * Login
	 * --------------
	 * @author Somwang Souksavatd
	 */
	public function login()
	{
		return View::make('user/login');
	}
	
	/**
	 * Logout
	 * ------
	 */
	public function logout() {
	
		Auth::logout();
	
		return Redirect::to('/user/login')->with('message', 'You are already logout.');
	}
	
	/**
	 * Login Submit
	 * ------------
	 * @author Somwang
	 */
	public function submit() {

		$rules = array(
	        'email'            => 'required|email',     // required and must be unique in the ducks table
	        'password'         => 'required'
    	);

    	$validator = Validator::make(Input::all(), $rules);
		
    	if ($validator->fails()) {
    	
    		// get the error messages from the validator
    		$messages = $validator->messages();
    	
    		// redirect our user back to the form with the errors from the validator
    		return Redirect::to('user/login')->withErrors($validator);
    	
    	} else {
    		
    		$userdata = array(
    				'login' => Input::get('email'),
    				'password' => Input::get('password')
    		);
    		
    		if (Auth::attempt($userdata)) {
    		
    			$user = User::find(Auth::id());
    			Session::put('user', $user);
    		
    			return Redirect::to('/');
    			
    		} else {
    		
    			return View::make('user/login')->with('message', 'Login info are not correct.');
    		}
    	
    	}
	}

}
