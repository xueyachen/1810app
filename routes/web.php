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


Route::get('/login','LoginController@login');

//curl_get
Route::get('/curl_get','CurlController@curl_get');
//curl获取token
Route::get('/curl_token','CurlController@curl_token');
Route::post('/curl3','CurlController@curl3');

//表单测试
Route::get('/form1','CurlController@form1');

//自定义菜单
Route::get('/menu','CurlController@menu');

//上传文件
Route::get('/upload','CurlController@upload');
Route::get('/uploaddo','CurlController@uploaddo');
Route::post('/file','CurlController@file');

Route::get('/encry','CurlController@encryption');



