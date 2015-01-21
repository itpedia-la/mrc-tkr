<?php

class LoginController extends Controller {

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
	 * Login Submit
	 * ------------
	 * @author Somwang
	 */
	public function submit() {

		$rules = array(
			'email'            => 'required',     // required and must be unique in the ducks table
			'password'         => 'required'
		);
		
		$messages = array(
			'email.required' => 'ກະລຸນາໃສ່  ອີເມວ',
			'password.required' => 'ກະລຸນາໃສ່ ລະຫັດຜ່ານ'
		);
	
		$validator = Validator::make(Input::all(), $rules, $messages);
	
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
	
				return Redirect::to('/dashboard');
				 
			} else {
	
				return Redirect::to('user/login')->with('message', 'ລະຫັດຜູ້ໃຊ້ ແລະ ລະຫັດຜ່ານບໍ່ຖືກຕ້ອງ');
			}
			 
		}
	}
}
