<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

/*~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
 !!                                                routes pour l'authentification                                                        !! ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~  */
Route::group(['prefix'=>'/auth'], function(){
	Route::post('/login', 'AuthController@login');
    Route::delete('/logout', 'AuthController@logout');
});


Route::get('/users/groups/{id}', 'RoleController@permissions');
Route::get('{id1}/invitations/{id2}/group/{id3}/{id4}', 'InvitationController@valid');
Route::get('/users/pwd/{id}', 'UserController@forget_pwd');
/*~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
 !!                                                 routes pour les operations sur les roles                                             !! ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~  */
Route::group(['prefix'=>'/role'], function(){
	Route::post('/', 'RoleController@add');
	Route::get('/', 'RoleController@get');
	Route::delete('/{id}', 'RoleController@delete');
	Route::get('/{id}', 'RoleController@find');
    Route::match(['put','post'],'/{id}','RoleController@update');
});


/*~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
 !!                                    ,'middleware'=>['auth:api']          rroutes pour les operations sur les utilisateurs                                        !! ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~  */
Route::group(['prefix'=>'/users'] , function(){
	Route::post('/', 'UserController@add');
	Route::get('/', 'UserController@get');
	Route::get('/{id}', 'UserController@find');
	Route::post('/pwdchange/{id}', 'UserController@change_pwd');
	Route::delete('/{id}', 'UserController@delete');
	Route::match(['put','post'],'/{id}','UserController@update');
});



/*~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
 !!                                               routes pour les operations sur les groupes                                             !! ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~  */
Route::group(['prefix'=>'/group'],function(){
	Route::post('/', 'GroupController@add');
	Route::get('/', 'GroupController@get');
	Route::get('/{id}', 'GroupController@find');
	Route::delete('/{id}', 'GroupController@delete');
	Route::match(['put','post'],'/{id}','GroupController@update');
});


/*~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
 !!                                              routes pour les operations sur les permissions                                          !! ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~  */
Route::group(['prefix'=>'/permissions'],function(){
	Route::post('/', 'PermissionController@add');
	Route::get('/', 'PermissionController@get');
	Route::get('/{id}', 'PermissionController@find');
	Route::delete('/{id}', 'PermissionController@delete');
	Route::match(['put','post'],'/{id}','PermissionController@update');
});


/*~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
 !!                                              routes pour les operations sur les invitations                                          !! ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~  */
Route::group(['prefix'=>'/invitations'],function(){
	Route::post('/', 'InvitationController@add');
	Route::get('/', 'InvitationController@get');
	Route::get('/mail', 'InvitationController@store');
	Route::get('/{id}', 'InvitationController@find');
	Route::delete('/{id}', 'InvitationController@delete');
	Route::match(['put','post'],'/{id}','InvitationController@update');
});


/*~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
 !!                                                    routes pour les roles d'utilisateurs                                              !! ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~  */
Route::group(['prefix'=>'/user_role'] , function(){
	Route::post('/', 'UserRoleController@add');
	Route::get('/', 'UserRoleController@get');
	Route::get('/{id}', 'UserRoleController@find');
	Route::delete('/{id}', 'UserRoleController@delete');
	Route::match(['put','post'],'/{id}','UserRoleController@update');
});

/*~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
 !!                                                routes pour les permissions des roles                                                 !! ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~  */
Route::group(['prefix'=>'/role_permission'] , function(){
	Route::post('/', 'RolePermissionController@add');
	Route::get('/', 'RolePermissionController@get');
	Route::get('/{id}', 'RolePermissionController@find');
	Route::delete('/{id}', 'RolePermissionController@delete');
	Route::match(['put','post'],'/{id}','RolePermissionController@update');
});


/*~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
 !!                                             routes pour les groupes d'utilisateurs                                                   !! ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~  */
Route::group(['prefix'=>'/user_group',] , function(){
	Route::post('/', 'UserGroupController@add');
	Route::get('/', 'UserGroupController@get');
	Route::get('/remove/{id}/{id1}', 'UserGroupController@removeAdmin');
	Route::get('/add/{id}/{id1}', 'UserGroupController@addAdmin');
	Route::get('/{id}', 'UserGroupController@find');
	Route::delete('/{id}', 'UserGroupController@delete');
	Route::match(['put','post'],'/{id}','UserGroupController@update');
});

//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~