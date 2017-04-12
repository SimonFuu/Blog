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

Route::post('login', 'LoginController@commonLogin');
Route::group(['prefix' => '/backend', 'namespace' => 'Backend'], function () {
    Route::get('/', 'IndexController@index');
});

Route::group(['prefix' => '/', 'namespace' => 'Frontend'], function () {
    Route::get('/', 'IndexController@index');
    Route::get('/article/{id}', 'ArticlesController@getArticle');
    Route::get('/catalog/{id}', 'CatalogsController@getCatalogArticles');
    Route::get('/tag/{id}', 'TagsController@getTagArticles');
    Route::get('/oauth/{service}', 'AuthController@redirectToProvider');
    Route::get('/oauth/{service}/callback', 'AuthController@handleProviderCallback');
    Route::group(['middleware' => 'Auth'], function () {

    });
});
