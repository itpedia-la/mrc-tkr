<?php

/*
|--------------------------------------------------------------------------
| Application & Route Filters
|--------------------------------------------------------------------------
|
| Below you will find the "before" and "after" events for the application
| which may be used to do any work before or after a request into your
| application. Here you may also register your custom route filters.
|
*/

App::before(function($request)
{
	//
});


App::after(function($request, $response)
{
	//
});

/*
|--------------------------------------------------------------------------
| Authentication Filters
|--------------------------------------------------------------------------
|
| The following filters are used to verify that the user of the current
| session is logged into this application. The "basic" filter easily
| integrates HTTP Basic authentication for quick, simple checking.
|
*/

Route::filter('auth', function()
{
	if (Auth::guest())
	{
		if (Request::ajax())
		{
			return Response::make('Unauthorized', 401);
		}
		else
		{
			return Redirect::guest('user/login');
		}
	}
});


Route::filter('auth.basic', function()
{
	return Auth::basic();
});

/**
 * Route Filter ( Customer User Access Role )
 * ------------------------------------------
 * @author Somwangs
 */
Route::filter('restrict', function($route, $request, $permissionCode) {

	if( Auth::id() ) {

		# Find loggin user
		$User = User::find(Auth::id());

		# If user.systemUser is not = 1
		if( $User->systemUser == 0 ) {

			# Find user_group_id
			$user_group_id = $User->user_group_id;
				
			# Find Group PermissionList
			$PermissionList = UserGroup::find($user_group_id);
			$PermissionList = $PermissionList->permissionList;

			# If user_group.permissionList isset
			if( $PermissionList ) {

				$PermissionList = json_decode($PermissionList,true);

				# check if user_group.permissionList is containing $permissionCode
				if ( !array_key_exists( $permissionCode, $PermissionList ) ) {

					# Find Permission Description
					$UserGroupPermission = UserGroupPermission::find($permissionCode);
					$permissionDescription = $UserGroupPermission->permissionDescription;
						
					if (Request::ajax()) {

						return Response::make('Unauthorized', 401);

					} else {

						return View::make('user/access_denied')->with('permissionCode',$permissionCode)->with('permissionDescription',$permissionDescription);

					}

				}

			} else {

				if (Request::ajax()) {

					return Response::make('Unauthorized', 401);

				} else {

					return View::make('user/access_denied')->with('permissionCode',$permissionCode)->with('permissionDescription',$permissionDescription);

				}

			}

		}

	} else {

		if (Request::ajax()) {

			return Response::make('Unauthorized', 401);

		} else {
				
			return Redirect::to('user/login')->with('message', 'ກະລຸນາເຂົ້າສູ່ລະບົບ');
				
		}

	}
});

/*
|--------------------------------------------------------------------------
| Guest Filter
|--------------------------------------------------------------------------
|
| The "guest" filter is the counterpart of the authentication filters as
| it simply checks that the current user is not logged in. A redirect
| response will be issued if they are, which you may freely change.
|
*/

Route::filter('guest', function()
{
	if (Auth::check()) return Redirect::to('/');
});

/*
|--------------------------------------------------------------------------
| CSRF Protection Filter
|--------------------------------------------------------------------------
|
| The CSRF filter is responsible for protecting your application against
| cross-site request forgery attacks. If this special token in a user
| session does not match the one given in this request, we'll bail.
|
*/

Route::filter('csrf', function()
{
	if (Session::token() != Input::get('_token'))
	{
		throw new Illuminate\Session\TokenMismatchException;
	}
});
