<?php

/**
 * Seat Controller
 * -------------------
 * @author Somwang
 *
 */
class SeatController extends Controller {

	public function __construct() {
	
		CustomerController::expiredDateCheck();
	}
	
	function home() {
		
		
		
		if( Auth::id() ) {
			# Check if manager
			$user_group_id = User::find(Auth::id());
			$user_group_id = $user_group_id->user_group_id;
			if( $user_group_id == 1 || $user_group_id == 2 ) {
				$allowFreeTicket = true;
			} else {
				$allowFreeTicket = false;
			}
		}
		
		/*echo "INSERT INTO seat (number) VALUES ('BR');<br/>";
		
		for( $i=1; $i <= 10; $i++ ) {
			echo "INSERT INTO seat (number, price, status, created_at, updated_at, remove) VALUES ('Z".$i."', '50000', 0, NOW(), NOW(), 0);<br/>";
		}
		
			echo "INSERT INTO seat (number) VALUES ('|');<br/>";
			
		for( $i=11; $i <= 20; $i++ ) {
			echo "INSERT INTO seat (number, price, status, created_at, updated_at, remove) VALUES ('Z".$i."', '50000', 0, NOW(), NOW(), 0);<br/>";
		}
		
			echo "INSERT INTO seat (number) VALUES ('|');<br/>";	
			
		for( $i=21; $i <= 30; $i++ ) {
			echo "INSERT INTO seat (number, price, status, created_at, updated_at, remove) VALUES ('Z".$i."', '50000', 0, NOW(), NOW(), 0);<br/>";
		}
			echo "INSERT INTO seat (number) VALUES ('|');<br/>";
			
		for( $i=31; $i <= 40; $i++ ) {
			echo "INSERT INTO seat (number, price, status, created_at, updated_at, remove) VALUES ('Z".$i."', '50000', 0, NOW(), NOW(), 0);<br/>";
		}
		
		echo "INSERT INTO seat (number) VALUES ('hr');<br/>";*/
		$showDate = Route::input('showDate');
		$VIP = Seat::where('id','>','0')->where('remove','=',0)->where('showDate',$showDate)->get()->toArray();

		foreach($VIP as $key => $value) {
			
			if ( $value['number'] == '|' ) {
				
				$value['seat'] = '<span class="saperate"></span>';
				
			} elseif( $value['number'] == 'BR' ) {
				
				$value['seat'] = HTML::entities('<br/><br/>');
			
			} elseif( $value['number'] == 'hr' ) {
				
				$value['seat'] = HTML::entities('</br><br/>---------------- <span class="tag fb">'.number_format($value['price']).'</span> ----------------</br></br>');
				
			} else {
				
				if( Auth::id() ) { 
					
					switch( $value['status'] ) {
							
						case 0:
							$class = 'seat_available '.$value['seatClass'];
							$number = $value['number'];
							break;
								
						case 1:
							$class = 'seat_pending';
							$number = $value['number'];
							break;
								
						case 2:
							$class = 'seat_paid';
							$number = $value['number'];
							break;
						case 3:
							$class = 'seat_issued';
							$number = $value['number'];
							break;
						default:
							$class = 'seat';
							$number = $value['number'];
							break;
					}

				} else {
					
					switch( $value['status'] ) {
							
						case 0:
							$class = 'seat_available '.$value['seatClass'];
							$number = $value['number'];
							break;
					
						case 1:
							$class = 'seat_reserved_public';
							$number = 'xx';
							break;
					
						case 2:
							$class = 'seat_reserved_public';
							$number = 'xx';
							break;
							case 3:
								$class = 'seat_reserved_public';
								$number = 'xx';
								break;
						default:
							$class = 'seat';
							$number = 'xx';
							break;
					}
				}
	
				$value['seat'] = '<span class="'.$class.'" data-id="'.$value['id'].'">'.$number.'</span>';
			}
			
			$VIP[$key] = $value;
		}
		
		/*echo '<pre>';
		print_r($VIP);
		echo '</pre>';
		exit();*/
		return View::make('seat/index')
			->with('allowFreeTicket',@$allowFreeTicket)
			->with('VIP',$VIP);
	}
	
}