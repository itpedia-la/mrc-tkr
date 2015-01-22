<?php

/**
 * Seat Controller
 * -------------------
 * @author Somwang
 *
 */
class SeatController extends BaseController {

	function home() {
		
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
		
		$VIP = Seat::where('id','>','0')->get()->toArray();

		foreach($VIP as $key => $value) {
			
			if ( $value['number'] == '|' ) {
				
				$value['seat'] = '<span class="saperate"></span>';
				
			} elseif( $value['number'] == 'BR' ) {
				
				$value['seat'] = HTML::entities('<br/><br/>');
			
			} elseif( $value['number'] == 'hr' ) {
				
				$value['seat'] = HTML::entities('</br><br/>--------------------------------------------------------------------------------------------------------</br></br>');
				
			} else {
				
				$value['seat'] = '<span class="seat available">'.$value['number'].'</span>';
			}
			
			$VIP[$key] = $value;
		}
		
		/*echo '<pre>';
		print_r($VIP);
		echo '</pre>';
		exit();*/
		return View::make('seat/index')
			
			->with('VIP',$VIP);
	}
	
}