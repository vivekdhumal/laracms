<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function(){	
	Auth::routes();

	Route::get('/', 'HomeController@index');

	Route::get('/home', 'HomeController@index');

	Route::get('/categories', 'CategoryController@desk')->name('admin.categories');

	Route::resource('/blog-categories', 'CategoryController', [	'except' => ['create', 'edit', 'show'] ]);

	Route::get('/tags', 'TagController@desk')->name('admin.tags');

	Route::resource('/blog-tags', 'TagController', [ 'except' => ['create', 'edit', 'show'] ]);

	Route::get('/posts', 'PostController@desk')->name('admin.posts');
});
