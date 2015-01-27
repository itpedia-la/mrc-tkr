<?php

/**
 * Seat Controller
 * -------------------
 * @author Somwang
 *
 */
class CustomerController extends Controller {

	function submit() {
	
		$rules = array(
				'fullname'            => 'required',     // required and must be unique in the ducks table
				'telephone'         => 'required',
				'address'         => 'required'
		);
		
		$messages = array(
				'fullname.required' => 'ຊື່ແລະນາມສະກຸນ',
				'telephone.required' => 'ເບີໂທລະສັບ',
				'address.required' => 'ທີ່ຢູ່'
		);
		
		$validator = Validator::make(Input::all(), $rules, $messages);
		
		if ($validator->fails()) {
		
			// get the error messages from the validator
			$messages = $validator->messages();
		
			// redirect our user back to the form with the errors from the validator
			//return Redirect::to('user/login')->withErrors($validator);
			return Response::json($messages, 500);
		
		} else {

			$seat = json_decode(urldecode(Input::get('seat')),true);
			
			# Update seat status
			$total = 0;
			foreach($seat as $key => $value ) {
				$Seat = Seat::find($value['value']);
				$Seat->status = 1;
				$Seat->save();
				
				$total = $total + $Seat->price;
			}

			$Customer = new Customer();
			$Customer->customer_name = Input::get('fullname');
			$Customer->telephone = Input::get('telephone');
			$Customer->address = Input::get('address');
			$Customer->seatJson = urldecode(Input::get('seat'));
			$Customer->user_id = Auth::id();
			$Customer->total = $total;
			$Customer->status = 0;
			$Customer->save();
			
			$id = Crypt::encrypt($Customer->id);
			return Response::json($id, 200);

		}
	}
	
}