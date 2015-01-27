<?php

class HomeController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	public function home()
	{
		return View::make('home/index');
	}

	public function done()
	{
		$id = Crypt::decrypt(Route::input('id'));
		$total = Customer::find($id);
		$total = number_format($total->total);
		
		return View::make('home/done')->with('total',$total);
	}
}
