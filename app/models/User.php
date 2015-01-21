<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'user';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password', 'remember_token');
	
	/**
	 * Get User List
	 * -------------
	 */
	public static function getAllUser() {
		
		$data = User::where('systemUser','=',0)->where('remove','=',0)->get()->toArray();
	
		foreach( $data as $key => $value ) {
			
			$user_group = UserGroup::where('id','=', $value['user_group_id'])->get()->toArray();
			$user_group = $user_group[0]['name'];
			
			$data[$key]['user_group'] = $user_group;
			$data[$key]['created_at'] = Tool::toDateTime($value['created_at']);
			$data[$key]['updated_at'] = Tool::toDateTime($value['updated_at']);
		}
		
		return $data;
	}
	
	/**
	 * Get User List By Group Id
	 * -------------------------
	 */
	public static function getAllUserByGroupId() {
	
		$user_group_id = Route::input('user_group_id');
		
		if( $user_group_id > 0 ) {
			
			$data = User::where('systemUser','=',0)->where('user_group_id','=',$user_group_id)->where('remove','=',0)->get()->toArray();
			
		} else {
			
			$data = User::where('systemUser','=',0)->where('remove','=',0)->get()->toArray();
		}
		
		foreach( $data as $key => $value ) {
				
			$user_group = UserGroup::where('id','=', $value['user_group_id'])->get()->toArray();
			$user_group = $user_group[0]['name'];
				
			$data[$key]['user_group'] = $user_group;
			$data[$key]['created_at'] = Tool::toDateTime($value['created_at']);
			$data[$key]['updated_at'] = Tool::toDateTime($value['updated_at']);
		}
	
		return $data;
	}
}
