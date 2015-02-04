<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

/**
 * Dashboard Route
 * ---------------
 */
Route::get('/', 'HomeController@home');
Route::get('done/{id}' , 'HomeController@done');
Route::get('seat/' , 'SeatController@home');
Route::get('seat/{showDate}' , 'SeatController@home');
Route::get('sale_list' , 'CustomerController@saleList');
Route::post('customer/submit' , 'CustomerController@submit');
Route::get('customer/ticket_issue/{customer_id}' , 'CustomerController@ticket_issue');
Route::post('customer/ticket_issue/submit' , 'CustomerController@ticket_issue_submit');
Route::post('customer/remove' , array('before'=>'restrict:5', 'uses' => 'CustomerController@remove') );
Route::post('customer/setPaid' , array('before'=>'restrict:6', 'uses' => 'CustomerController@setPaid') );
Route::post('customer/setIssued' , array('before'=>'restrict:6', 'uses' => 'CustomerController@setIssued') );
Route::get('report/all', array('before'=>'restrict:7', 'uses' => 'CustomerController@reportAll'));
Route::get('report/custom/{user_id}/{status}', array('before'=>'restrict:7', 'uses' => 'CustomerController@reportCustom'));
Route::get('report/user/{user_id}', array('before'=>'restrict:7', 'uses' => 'CustomerController@reportByUser'));
Route::get('report/person', array('before'=>'restrict:8', 'uses' => 'CustomerController@reportPerson'));

/**
 * User Route
 * ----------
 */
Route::get('/bob-admin', 'LoginController@login');
Route::post('user/login/submit', 'LoginController@submit');
Route::get('user/logout','UserController@logout');
Route::get('user/list', array('before'=>'restrict:3', 'uses' => 'UserController@userList'));

# User Json
Route::get('user/json/list' , array('before'=>'restrict:3', 'uses' => 'UserController@userListJson'));
Route::get('user/json/group' , 'UserController@userGroupJson');
Route::get('user/json/list/group/{user_group_id}' , array('before'=>'restrict:3', 'uses' => 'UserController@userListByGroupIdJson'));

# User form action
Route::get('user/form', array('before'=>'restrict:1', 'uses' => 'UserController@form'));
Route::post('user/form/submit', 'UserController@formSubmit');

# change password route
Route::get('user/changepassword/{user_id}', array('before'=>'restrict:4', 'uses' => 'UserController@changepassword'));
Route::post('user/changepassword/submit', array('before'=>'restrict:4', 'uses' => 'UserController@changepasswordSubmit'));

# user remove route
Route::get('user/remove/{user_id}', array('before'=>'restrict:2', 'uses' => 'UserController@userRemove'));
Route::post('user/remove/submit', array('before'=>'restrict:2', 'uses' => 'UserController@userRemoveSubmit'));

# group permission route
Route::get('user/group/permission/{group_id}', array('before'=>'restrict:10', 'uses' => 'UserController@groupPermission'));
Route::post('user/group/permission/submit', array('before'=>'restrict:10', 'uses' => 'UserController@groupPermissionSubmit'));

# user permission route
Route::get('user/access/denied' , 'UserController@userAccessDenied');

