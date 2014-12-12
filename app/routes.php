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

Route::get('/', function()
{
	return View::make('hello');
});

Route::get('/', array('as' => 'home', 'uses' => 'HomeController@index'));

Route::group(array('before' => 'un_auth'), function()
{
	Route::get('/login', array('as' => 'login', 'uses' => 'UsersController@login'));
	Route::get('/register', array('as' => 'register', 'uses' => 'UsersController@register'));
	Route::get('/logout', array('as' => 'logout', 'uses' => 'UsersController@logout'));

	Route::post('/login', array('as' => 'login', 'uses' => 'UsersController@handleLogin'));
	Route::post('/registratioin', array('as' => 'registratioin', 'uses' => 'UsersController@registratioin'));
});


Route::group(array('before' => 'is_auth'), function()
{

	Route::get('/updateUser', array('as' => 'updateUser', 'uses' => 'UsersController@updateUser'));
	
	Route::get('/profile', array('as' => 'profile', 'uses' => 'UsersController@profile'));
	Route::post('/profile', array('as' => 'profile', 'uses' => 'UsersController@profile'));
	Route::resource('roles', 'RolesController');
    Route::resource('companies', 'CompaniesController');
	Route::resource('groups', 'GroupsController');
	Route::get('/add', array('as' => 'add', 'uses' => 'ItemsController@create'));
	
	Route::get('/createAdminGroup', array('as' => 'createAdmin', 'uses' => 'GroupsController@createAdmin'));
	Route::get('/assignGroup', array('as' => 'assignGroup', 'uses' => 'GroupsController@assignGroup'));
	

});


Route::filter('is_auth', function()
{
    if (!Sentry::check()) {
        return Redirect::to('login');
    }
});

Route::filter('un_auth', function()
{
    if (Sentry::check()) {
        Sentry::logout();
    }
});