<?php

/**
 * Seat Controller
 * -------------------
 * @author Somwang
 *
 */
class CustomerController extends Controller {
	
	public function __construct() {
		
		CustomerController::expiredDateCheck();
	}
	/**
	 * Customer Report All
	 * -------------------
	 */
	function reportAll() {
		$data = Customer::getReportAll();
		$sumary = Customer::sumary();
		
		return View::make('report/all')->with('data',$data)->with('sumary',$sumary);
		
	}
	
	function reportCustom() {
		$user_id = Route::input('user_id');
		$status = Route::input('status');
		$data = Customer::getReportByUserWithStatus($user_id, $status);
		$sumary = Customer::sumaryByUserWithStatus($status, $user_id);
		return View::make('report/all')->with('data',$data)->with('sumary',@$sumary);
		
	}
	/**
	 * Customer By user_id
	 * -------------------
	 */
	function reportByUser() {
		
		$user_id = Route::input('user_id');
		
		$data = Customer::getReportByUser($user_id);
		$sumary = Customer::sumaryByUser($user_id);
	
		return View::make('report/all')->with('data',$data)->with('sumary',$sumary);
	
	}

	/**
	 * Customer Report Personal
	 * ------------------------
	 */
	function reportPerson() {
		
		$data = Customer::getReportAll();
		$sumary = Customer::sumaryPerson();
		$data = Customer::getReportPersonal();

		return View::make('report/person')->with('data',$data)->with('sumary',$sumary);
	}
	
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
			$Customer->showDate = Input::get('showDate');
			$Customer->user_id = Auth::id();
			$Customer->total = Input::get('freeTicket') == 1 ? 0 : $total;
			$Customer->status = 0;
			$Customer->save();
			
			$CustomerUpdate = Customer::find($Customer->id);
			$CustomerUpdate->expired_at = date('Y-m-d',strtotime( $CustomerUpdate->created_at ) + (24*3600*3));
			$CustomerUpdate->save();
			
			$id = Crypt::encrypt($Customer->id);
			return Response::json($id, 200);

		}
	}
	
	function remove() {
		
		$Customer = Customer::find(Input::get('id'));
		$Customer->status = 3;
		
		$seats = json_decode($Customer->seatJson,true);
		
		foreach( $seats as $i ) {
			$s = Seat::find($i['value']);
			$s->status = 0;
			$s->save();
		}
		
		$Customer->save();

		return Response::json(null, 200);
	}
	
	function setPaid() {
	
		$Customer = Customer::find(Input::get('id'));
		$Customer->status = 1;
	
		$seats = json_decode($Customer->seatJson,true);
	
		foreach( $seats as $i ) {
			$s = Seat::find($i['value']);
			$s->status = 2;
			$s->save();
		}
	
		if( $Customer->user_id == null ) {
			$Customer->user_id = Auth::id();
		}
		
		$Customer->save();
	
		return Response::json(null, 200);
	}
	
	function setIssued() {
	
		$Customer = Customer::find(Input::get('id'));
		$Customer->status = 2;
	
		$seats = json_decode($Customer->seatJson,true);
	
		foreach( $seats as $i ) {
			$s = Seat::find($i['value']);
			$s->status = 3;
			$s->save();
		}
	
		$Customer->save();
	
		return Response::json(null, 200);
	}
	
	public static function expiredDateCheck() {
		
		$Customer = Customer::where('status','=',0)->where('remove','=',0)->get()->toArray();
		
		foreach( $Customer as $key => $value ) {
			
			if( strtotime(date('Y-m-d',time())) > strtotime($value['expired_at'])) {
				
				$CustomerUpdate = Customer::find($value['id']);
				$CustomerUpdate->status = 3;
				
				# Update Seat Status
				$seats = json_decode($CustomerUpdate->seatJson,true);
				
				foreach( $seats as $i ) {
					$s = Seat::find($i['value']);
					$s->status = 0;
					$s->save();
				}
				
				$CustomerUpdate->save();

			}
		}

	}
	
	/**
	 * Get Sales list by user
	 * ----------------------
	 */
	public function saleList() {
	
		$data = Customer::orderBy('user_id')->groupBy('user_id')->get()->toArray();

		foreach ( $data as $key => $value ) {

			if( $value['user_id'] > 0 ) {
				
				$user = User::find($value['user_id']);
				$user = $user->firstname;
				
			} else {
				
				$user = 'ລູກຄ້າ';
				
			}
			$result[$key]['user_id'] = $value['user_id'] > 0 ? $value['user_id'] : 0;
			$result[$key]['user'] = $user;
		}
		
		return Response::json($result)->setCallback(Input::get('callback'));
	
	}
	
}