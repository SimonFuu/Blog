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

Route::post('/login', 'LoginController@commonLogin');
Route::get('/oauth/{service}', 'LoginController@redirectToProvider');
Route::get('/oauth/{service}/callback', 'LoginController@handleProviderCallback');
Route::get('/user/bind', 'LoginController@userBind');
Route::post('/user/bind', 'LoginController@storeUserBind');
Route::get('/user/bind/confirmation/{token}', 'LoginController@bindConfirm');
Route::get('/logout', 'LoginController@logout');

Route::group(['prefix' => '/backend', 'middleware' => 'backend', 'namespace' => 'Backend'], function () {
    Route::get('/', 'IndexController@index');
});
Route::group(['prefix' => '/', 'namespace' => 'Frontend'], function () {
    Route::get('/', 'IndexController@index');
    Route::get('/article/{id}', 'ArticlesController@getArticle');
    Route::get('/catalog/{id}', 'CatalogsController@getCatalogArticles');
    Route::get('/tag/{id}', 'TagsController@getTagArticles');
    Route::post('/article/comment', 'CommentController@store');
    Route::get('/article/comment/delete/{id}', 'CommentController@deleteComment');
    Route::get('/mail', 'IndexController@mail');
});

Route::get('/mailt', function () {
    return view('mail.bind');
});
