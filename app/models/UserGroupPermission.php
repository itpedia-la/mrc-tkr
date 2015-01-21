<?php

/**
 * User Group Permission
 * ---------------------
 * @author Somwang 
 *
 */
class UserGroupPermission extends Eloquent {

	protected $table = 'user_group_permission';

	/**
	 * Get Group Permission List
	 * -------------------------
	 * @return unknown
	 */
	public static function GetGroupPermissionList($user_group_id) {
		
		$GroupPermissions = UserGroupPermission::all()->toArray();
		
		# Find user_group.permissionList
		$UserGroup = UserGroup::find($user_group_id);
		$permissionList = json_decode($UserGroup->permissionList,true);
	
		foreach( $GroupPermissions as $key => $value ) {
			
			# Find current permission list from user Group
			if( $permissionList ) {
				$checked = array_key_exists( $value['id'], $permissionList ) ? $checked = 'checked="checked"' : $checked = "";
				$value['checked'] = $checked;
			}

			$Group[$value['permissionZone']][] = $value;
			
		}
		
		
		return $Group;
	}
}