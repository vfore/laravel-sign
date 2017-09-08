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

Route::any('/wechat', 'WeChatController@serve');

Route::group(['middleware' => ['web', 'wechat.oauth']], function () {
	Route::get('/user', 'WeChatController@user');
    Route::get('/sign/{id}', 'WeChatController@sign');
    Route::any('/index', 'WeChatController@index');
    Route::get('/confirm', function () {
        return view('confirm');
    });
});

Route::get('/my', function () {
    return view('my');
});

Route::get('/addMenu', 'WeChatController@addMenu');
