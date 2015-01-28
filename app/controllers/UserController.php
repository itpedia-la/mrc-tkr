<?php

/**
 * User Controller
 * -------------------
 * @author Somwang
 *
 */
class UserController extends BaseController {

	/**
	 * Logout
	 * ------
	 * @author Somwang
	 */
	public function logout() {
	
		Auth::logout();
	
		return Redirect::to('/bob-admin')->with('message', 'ທ່ານໄດ້ອອກຈາກລະບົບແລ້ວ');
	}
	
	/**
	 * User Form
	 * ---------
	 * @author Somwang
	 */
	public function form() {
		
		return View::make('user/form');
	}

	/**
	 * User List
	 * ---------
	 * @author Somwang
	 */
	public function userList() {
		
		return View::make('user/list');
	}
	
	/**
	 * User List JSONP
	 * ---------------
	 * @author Somwang
	 */
	public function userListJson() {
		
		$data = User::getAllUser();
		
		return Response::json($data)->setCallback(Input::get('callback'));
		
	}
	
	/**
	 * User List JSONP By Group Id
	 * ---------------------------
	 * @author Somwang
	 */
	public function userListByGroupIdJson() {
	
		$data = User::getAllUserByGroupId();
	
		return Response::json($data)->setCallback(Input::get('callback'));
	
	}
	
	/**
	 * User Group JSONP
	 * -----------------
	 */
	public function userGroupJson() {

		$data = UserGroup::where('id','>',0)->where('invisible','=','0')->get()->toArray();
		
		return Response::json($data)->setCallback(Input::get('callback'));
		
	}
	
	/**
	 * User Form Submit
	 * ------------------
	 * @author Somwang
	 */
	public function formSubmit() {
		
		$rules = array(
			'user_group_id' => 'required',
	        'login'            => 'required',     // required and must be unique in the ducks table
	        'password'         => 'required|min:6',
			'firstname'         => 'required'
    	);
		
		$messages = array(
			'user_group_id.required' => 'ກະລຸນາເລື່ອກຸ່ມຜູ້ໃຊ້',
			'login.required' => 'ກະລຸນາໃສ່ລະຫັດ ຫລື ອີເມວ',
			'password.required' => 'ກະລຸນາໃສ່ລະຫັດຜ່ານ',	
			'firstname.required' => 'ກະລຸນາ ໃສ່ ຊື່ ແລະ ນາມສະກຸນ',
		);
		
		$validator = Validator::make(Input::all(), $rules , $messages);
		
		if ($validator->fails()) {
			 
			// get the error messages from the validator
			$messages = $validator->messages();
			 
			// redirect our user back to the form with the errors from the validator
			return Redirect::to('user/form')->withErrors($validator)->with('input',Input::all());
			 
		} else {

			$User = new User();
			$User->user_group_id = Input::get('user_group_id');
			$User->login = Input::get('login');
			$User->password = Hash::make( Input::get('password') );
			$User->firstname = Input::get('firstname');
			$User->lastname = Input::get('lastname');
			//$User->disabled = Input::get('disabled');
			$User->remove = Input::get('remove');
			$User->systemUser = 0;
			$User->save();
		
			return Redirect::to('user/list')->with('message', 'ຜູ້ໃຊ້ງານໄດ້ຖືກເພີ່ມເຂົ້າໃນລະບົບແລ້ວ.');

		}
	}
	
	/**
	 * Change password
	 * ---------------
	 * @author Somwang
	 */
	function changepassword() {
		
		return View::make('user/changepassword');
		
	}
	
	/**
	 * Chagne Password Submit
	 * ----------------------
	 * @author Somwang
	 */
	function changepasswordSubmit() {
		
		$user_id = Input::get('user_id');
		
		$rules = array(
	        'password'         => 'required|min:6',
    	);
		
		$messages = array(
			'password.required' => 'ກະລຸນາໃສ່ລະຫັດຜ່ານ',	
		);
		
		$validator = Validator::make(Input::all(), $rules , $messages);
		
		if ($validator->fails()) {
			 
			// get the error messages from the validator
			$messages = $validator->messages();
			 
			// redirect our user back to the form with the errors from the validator
			return Redirect::to('user/changepassword/'.$user_id)->withErrors($validator)->with('input',Input::all());
			 
		} else {

			$User = User::find($user_id);
			$User->password = Hash::make( Input::get('password') );
			$User->save();
		
			return Redirect::to('user/list')->with('message', 'ລະຫັດຜ່ານໄດ້ຖືກປ່ຽນແລ້ວ.');

		}
	}
	
	/**
	 * User Remove
	 * -----------
	 * @author Somwang
	 */
	function userRemove() {
		
		return View::make('user/remove');
	}
	
	/**
	 * User remove submit
	 * ------------------
	 * @author Somwang
	 */
	function userRemoveSubmit() {
		
		$User = User::find(Input::get('user_id'));
		$User->remove = 1;
		$User->save();
		
		return Redirect::to('user/list')->with('message','ຜູ້ໃຊ້ງານໄດ້ຖືກລົບລ້າງແລ້ວ');
	}
	
	/**
	 * Set Group Permission
	 * --------------------
	 * @author Somwang
	 */
	function groupPermission() {
		
		$user_group_id = Route::input('group_id');
		
		# Find Group Name
		$Group = UserGroup::find($user_group_id)->toArray();
		
		# Find User Permission Group
		$GroupPermission = UserGroupPermission::GetGroupPermissionList($user_group_id);

		return View::make('user/group_permission')->with('group',$Group['name'])->with('GroupPermission', $GroupPermission);
	}
	
	/**
	 * Group Permission Submit
	 * -----------------------
	 */
	function groupPermissionSubmit() {

		$user_group_id = Input::get('user_group_id');
		
		if( !empty($_POST['permission']) ) {
			
			# Convert array to json format
			$permissionList = json_encode($_POST['permission']);
			
			# Save permission
			$UserGroup = UserGroup::find($user_group_id);
			$UserGroup->permissionList = $permissionList;
			$UserGroup->save();
			
			return Redirect::to('user/list')->with('message','ສິດກຸ່ມຜູ້ໃຊ້ງານໄດ້ຖືກບັນທິກແລ້ວ.');
			
		} else {
			
			return Redirect::to('user/group/permission/'.$user_group_id)->with('message','ກະລຸນາກຳໜົດສິດໃຫ້ກຸ່ມຜູ້ໃຊ້ງານ.');
		}

	}
	
	/**
	 * User Access Denied
	 * ------------------
	 */
	function userAccessDenied() {
		
		return View::make('user/access_denied');
	}

	/**
	 * User Restrict Check
	 * -------------------
	 * @param int $permissionCode ( permission code from user_group_permission.id )
	 */
	public static function Ristrict($permissionCode) {


	}

}
