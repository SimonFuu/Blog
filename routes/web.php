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
Route::get('/user/bind', function () {
    return view('frontend.bind');
});
Route::post('/user/bind', 'LoginController@bindEmailAddress');
Route::get('/logout', 'LoginController@commonLogout');

Route::group(['prefix' => '/backend', 'middleware' => 'backend', 'namespace' => 'Backend'], function () {
    Route::get('/', 'IndexController@index');
});
Route::group(['prefix' => '/', 'namespace' => 'Frontend'], function () {
    Route::get('/', 'IndexController@index');
    Route::get('/article/{id}', 'ArticlesController@getArticle');
    Route::get('/catalog/{id}', 'CatalogsController@getCatalogArticles');
    Route::get('/tag/{id}', 'TagsController@getTagArticles');
    Route::post('/article/comment', 'CommentController@store');
});

