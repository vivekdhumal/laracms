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

	Route::resource('/blog-categories', 'CategoryController', ['except' => ['create', 'edit', 'show'] ]);

	Route::get('/blog-categories/all', 'CategoryController@allCategories');

	Route::get('/tags', 'TagController@desk')->name('admin.tags');

	Route::resource('/blog-tags', 'TagController', ['except' => ['create', 'edit', 'show'] ]);

	Route::get('/blog-tags/all', 'TagController@allTags');

	Route::get('/posts', 'ArticleController@desk')->name('admin.posts');

	Route::resource('/blog-articles', 'ArticleController', [ 'except' => ['create', 'show'] ]);

	Route::post('/blog-articles/file-upload', 'ArticleController@fileUpload');
});
