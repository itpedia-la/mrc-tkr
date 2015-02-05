<?php

/**
 * Customer
 * --------------
 * @author Somwang 
 *
 */
class Customer extends Eloquent {

	protected $table = 'customer';
	
	/**
	 * Get Report Personal
	 * -------------------
	 */
	public static function getReportPersonal() {
		
		$Customers = Customer::where('user_id','=', Auth::id() )->orWhere('user_id','=',null)->where('remove','=',0)->orderBy('id','desc')->get()->toArray();
		
		$data = Customer::rebuild($Customers);
		
		return $data;
		
	}
	
	/**
	 * Get Report All
	 * --------------
	 */
	public static function getReportAll() {
		
		$Customers = Customer::where('remove','=', 0 )->orderBy('id','desc')->get()->toArray();
		
		$data = Customer::rebuild($Customers);
		
		return $data;
	}
	
	/**
	 * Get Report By User
	 * -----------------
	 */
	public static function getReportByUserWithStatus($user_id, $status) {

		if( $status == "all") {
			$Customers = Customer::where('user_id','=',$user_id)->where('remove','=', 0 )->orderBy('id','desc')->get()->toArray();
		} else {
			$Customers = Customer::where('user_id','=',$user_id)->where('status','=',$status)->where('remove','=', 0 )->orderBy('id','desc')->get()->toArray();
		}

		$data = Customer::rebuild($Customers);
	
		return $data;
	}
	
	/**
	 * Get Report By User
	 * --------------
	 */
	public static function getReportByUser($user_id) {
	
		if( $user_id == 0 ) {
			
			$Customers = Customer::where('user_id','=',null)->where('remove','=', 0 )->orderBy('id','desc')->get()->toArray();
			
		} else {
			
			$Customers = Customer::where('user_id','=',$user_id)->where('remove','=', 0 )->orderBy('id','desc')->get()->toArray();
			
		}

		$data = Customer::rebuild($Customers);
	
		return $data;
	}
	
	
	/**
	 * Rebuild Array
	 * -------------
	 */
	public static function rebuild($data) {
		
		foreach( $data as $key => $value ) {
			
			$seatJson = json_decode( $value['seatJson'], true);
			
			# Explode Json seat
			foreach( $seatJson as $jKey => $jValue) {
				
				$seat = Seat::find($jValue['value']);
				
				if( $value['status'] == 1 ) {
	
					$seatJson[$jKey]['name'] = '<span class="seat_seat_paid">'.$jValue['name'].'</span>';
		
				} elseif( $value['status'] == 2 ) {
					
					$seatJson[$jKey]['name'] = '<span class="seat_issued">'.$jValue['name'].'</span>';
					
				} elseif($value['status'] == 3 ) {
					
					$seatJson[$jKey]['name'] = '<span class="seat_cancelled">'.$jValue['name'].'</span>';
					
				} else {

					//$seatJson[$jKey]['name'] = Customer::SeatStatusAdjust($jValue['name'], $seat->status );
					$seatJson[$jKey]['name'] = '<span class="seat_pending">'.$jValue['name'].'</span>';
				}
				
				$seatJson[$jKey]['status'] = $seat->status;
			}
			
			# Find user
			if( $value['user_id'] > 0 ) {
				$User = User::find($value['user_id']);
				$User = $User->firstname;
			} else {
				$User = 'ລູກຄ້າ';
			}
			
			$data[$key]['total'] = number_format($value['total']).' ກີບ';
			$data[$key]['created_at'] = Tool::toDateTime($value['created_at']);
			$data[$key]['updated_at'] = Tool::toDateTime($value['updated_at']);
			$data[$key]['expired_at'] = Tool::toDate($value['expired_at']);
			$data[$key]['user'] = @$User;
			$data[$key]['seat'] = $seatJson;
			$data[$key]['showDate'] = Tool::toDate($value['showDate']);
			$data[$key]['statusHtml'] = Customer::CustomerStatusAdjust($value['status']) ;
		}
		
		return $data;
	}
	
	/**
	 * Status Adjust span
	 * ------------------
	 */
	public static function SeatStatusAdjust($name, $status) {
		
		switch( $status ) {
			
			case 1: 
				$seat = '<span class="seat_pending">'.$name.'</span>';
				break;
				
			case 2:
				$seat = '<span class="seat_paid">'.$name.'</span>';
				break;
				
			case 3:
				$seat = '<span class="seat_issued">'.$name.'</span>';
				break;
				
			default:
				$seat = '<span class="seat_available">'.$name.'</span>';
				break;
		}
		
		return $seat;
		
	}
	
	/**
	 * Status Adjust span
	 * ------------------
	 */
	public static function CustomerStatusAdjust($status) {
	
		switch( $status ) {
				
			case 0:
				$status = '<span style="background:orange; color:#000">ລໍຖ້າຈ່າຍເງິນ</span>';
				break;
	
			case 1:
				$status = '<span style="background:green; color:#000">ລໍຖ້າຮັບປີ້</span>';
				break;
	
			case 2:
				$status = '<span style="background:blue; color:#fff">ຮັບປີ້ແລ້ວ</span>';
				break;
				
			case 3:
				$status = '<span style="background:red; color:#fff">ຍົກເລີກ</span>';
				break;
				
			default:
				$status = '<span class="background:red; color:#fff">n/a</span>';
				break;
		}
	
		return $status;
	
	}
	
	public static function sumary() {

		$total = DB::table('customer')->where('remove','0',0)->whereIn('status',array(0,1,2))->sum('total');
		
		$totalPaid = DB::table('customer')->where('remove','0',0)->whereIn('status', array(1,2))->sum('total');
		
		$totalLeft = $total - $totalPaid;

		return array('totalPending'=>number_format($total).' ກີບ','totalPaid'=>number_format($totalPaid).' ກິບ', 'totalLeft'=>number_format($totalLeft).' ກີບ');
	}
	
	public static function sumaryPerson() {
	
		$total = DB::table('customer')->where('remove','0',0)->whereIn('status',array(0,1,2))->where('user_id','=',Auth::id())->sum('total');
	
		$totalPaid = DB::table('customer')->where('remove','0',0)->whereIn('status', array(1,2))->where('user_id','=',Auth::id())->sum('total');
	
		$totalLeft = $total - $totalPaid;
	
		return array('totalPending'=>number_format($total).' ກີບ','totalPaid'=>number_format($totalPaid).' ກິບ', 'totalLeft'=>number_format($totalLeft).' ກີບ');
	}
	
	public static function sumaryByUser($user_id) {
	
		$total = DB::table('customer')->where('remove','0',0)->whereIn('status',array(0,1,2))->where('user_id','=',$user_id)->sum('total');
	
		$totalPaid = DB::table('customer')->where('remove','0',0)->whereIn('status', array(1,2))->where('user_id','=',$user_id)->sum('total');
	
		$totalLeft = $total - $totalPaid;
	
		return array('totalPending'=>number_format($total).' ກີບ','totalPaid'=>number_format($totalPaid).' ກິບ', 'totalLeft'=>number_format($totalLeft).' ກີບ');
	}
	
	public static function sumaryByUserWithStatus($status, $user_id) {
	
		$total = DB::table('customer')->where('remove','0',0)->where('status','=',$status)->where('user_id','=',$user_id)->sum('total');
	
		$totalPaid = DB::table('customer')->where('remove','0',0)->where('status','=',$status)->where('user_id','=',$user_id)->sum('total');
	
		$totalLeft = $total - $totalPaid;
	
		return array('totalPending'=>number_format($total).' ກີບ','totalPaid'=>number_format($totalPaid).' ກິບ', 'totalLeft'=>number_format($totalLeft).' ກີບ');
	}
	
	

}
