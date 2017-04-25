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

Route::get('blog/{slug}', ['as' => 'blog.single', 'uses' => 'BlogController@getSingle'])->where('slug', '[\w\d\-\_]+' );
Route::get('blog', ['as' => 'blog.index', 'uses' => 'BlogController@getIndex']);

Route::get('/', 'PagesController@getIndex');

Route::get('/contact', 'PagesController@getContact');

Route::get('/about', 'PagesController@getAbout');


Route::group(['middleware' => 'auth'], function()
{
    Route::resource('posts', 'PostController');
});

Auth::routes();

Route::get('login/instagram', ['as' => 'oauth.instagram', 'uses' => 'Auth\LoginController@redirectToProvider']);
Route::get('login/instagram/callback', ['as' => 'oauth.instagram.callback', 'uses' => 'Auth\LoginController@handleProviderCallback']);

Route::get('/home', 'HomeController@index');

//categories
Route::resource('categories', 'CategoryController', ['except' => ['create']]);

//tags
Route::resource('tags', 'TagController', ['except' => ['create']]);