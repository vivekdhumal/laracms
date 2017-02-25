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

Route::get('/',  'BlogController@index');

Route::get('/article/{slug}',  'BlogController@article');

Route::get('/category/{slug}',  'BlogController@category');

Route::get('/tag/{slug}',  'BlogController@tag');

Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function(){	
	Auth::routes();

	Route::get('/', 'HomeController@index');

	Route::get('/home', 'HomeController@index');

	Route::resource('/categories', 'CategoryController', ['except' => ['create', 'edit', 'show'] ]);

	Route::get('/categories/all', 'CategoryController@allCategories');

	Route::resource('/tags', 'TagController', ['except' => ['create', 'edit', 'show'] ]);

	Route::get('/tags/all', 'TagController@allTags');

	Route::resource('/articles', 'ArticleController', [ 'except' => ['create', 'show'] ]);

	Route::post('/articles/file-upload', 'ArticleController@fileUpload');

	Route::resource('/users', 'UserController', ['except' => ['create', 'show'] ]);
});
