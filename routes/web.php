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
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//Users Routes
Route::get('/profiles/{user}', 'ProfilesController@show');
Route::post('api/users/{user}/avatar', 'Api\UserAvatarController@store')->middleware('auth');

//Blog routes
Route::get('/blog', 'PostsController@index')->name('blog');
Route::get('/blog/create', 'PostsController@create')->name('blogPostCreate')->middleware('auth');
Route::get('/blog/{category}', 'PostsController@index');
Route::post('/blog', 'PostsController@store')->name('blogPostStore')->middleware('auth');
Route::get('/blog/{category}/{post}', 'PostsController@show')->name('blogPost');
Route::get('/blog/{category}/{post}/edit', 'PostsController@edit')->name('blogPostEdit')->middleware('auth');
Route::patch('/blog/{category}/{post}', 'PostsController@update')->name('blogPostUpdate')->middleware('auth');
Route::delete('/blog/{category}/{post}', 'PostsController@destroy')->name('blogPostDelete')->middleware('auth');
Route::post('/blog/{category}/{post}/replies', 'RepliesController@store')->name('blogAddReply');

//Forum routes
Route::get('/forum', 'ThreadsController@index')->name('forum');
Route::get('/forum/create', 'ThreadsController@create')->name('forumThreadCreate')->middleware('auth');
Route::get('/forum/{category}', 'ThreadsController@index');
Route::post('/forum', 'ThreadsController@store')->name('forumThreadStore')->middleware('auth');
Route::get('/forum/{category}/{thread}', 'ThreadsController@show')->name('forumThread');
Route::get('/forum/{category}/{thread}/edit', 'ThreadsController@edit')->name('forumThreadEdit')->middleware('auth');
Route::patch('/forum/{category}/{thread}', 'ThreadsController@update')->name('forumThreadUpdate')->middleware('auth');
Route::delete('/forum/{category}/{thread}', 'ThreadsController@destroy')->name('forumThreadDelete')->middleware('auth');
Route::post('/forum/{category}/{thread}/replies', 'RepliesController@store')->name('forumAddReply');

//Administration routes
Route::get('/dashboard', 'DashboardController@index')->name('blog')->name('dashboard')->middleware('auth');
