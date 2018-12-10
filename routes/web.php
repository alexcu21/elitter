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

Route::get('/', 'PagesController@home' );

Route::get('/messages/{message}', 'MessagesController@show');

Auth::routes();

Route::get('/auth/facebook', 'SocialAuthController@facebook');
Route::get('/auth/facebook/callback', 'SocialAuthController@callback');
Route::post('/auth/facebook/register', 'SocialAuthController@register');


Route::get('/home', 'HomeController@index')->name('home');
Route::get('/messages', 'MessagesController@search');
//routes need auth
Route::group(['middleware' => 'auth'], function(){
  Route::post('/messages/create', 'MessagesController@create');
  Route::post('{username}/dms', 'UserController@sendPrivateMessage');
  Route::get('/conversations/{conversation}', 'UserController@showConversation');
  Route::get('/{username}/follows', 'UserController@follows');
  Route::post('/{username}/unfollow', 'UserController@unfollow');
  Route::get('/api/notifications', 'UserController@notifications');
  Route::delete('/messages/{message}', 'MessagesController@destroy');
});

Route::get('/api/messages/{message}/responses', 'MessagesController@responses');

Route::get('/{username}/followers', 'UserController@followers');
Route::post('/{username}/follow', 'UserController@follow');
Route::get('/{username}', 'UserController@show');
