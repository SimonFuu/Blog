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
# 用户登陆
Route::post('/login', 'LoginController@commonLogin');
# OAuth登陆
Route::get('/oauth/{service}', 'LoginController@redirectToProvider');
# OAuth登陆回调
Route::get('/oauth/{service}/callback', 'LoginController@handleProviderCallback');
# OAuth绑定用户邮箱
Route::get('/user/bind', 'LoginController@userBind');
Route::post('/user/bind', 'LoginController@storeUserBind');
# 验证绑定邮箱
Route::get('/user/bind/confirmation/{token}', 'LoginController@bindConfirm');
# 用户退出登陆
Route::get('/logout', 'LoginController@logout');
# 后台
Route::group(['prefix' => '/admin', 'middleware' => 'admin', 'namespace' => 'Admin'], function () {
    # 后台首页
    Route::get('/', 'IndexController@index');
    Route::group(['prefix' => 'contents'], function () {
        # 文章列表
        Route::get('/articles', 'ArticlesController@articlesList');
        # 取消文章置顶
        Route::get('/articles/un-stick/{id}', 'ArticlesController@unStickArticles');
        # 设置文章置顶
        Route::post('/articles/stick', 'ArticlesController@stickArticles');
        # 将文章移至回收站
        Route::get('/articles/delete/{id}', 'ArticlesController@moveToTrash');
        # 编辑文章
        Route::get('/articles/edit/{id}', 'ArticlesController@articleForm');
        # 添加文章
        Route::get('/articles/add', 'ArticlesController@articleForm');
        # 保存文章
        Route::post('/articles/store', 'ArticlesController@storeArticle');
        # 目录分类列表及添加表单
        Route::get('/catalogs', 'CatalogsController@catalogsList');
        Route::get('/tags', 'TagsController@tagsList');
    });
    # 文件上传
    Route::post('/upload/{type}', 'UploadFilesController@store');
});
# 前台
Route::group(['prefix' => '/', 'namespace' => 'Frontend'], function () {
    Route::get('/', 'IndexController@index');
    Route::get('/article/{id}', 'ArticlesController@getArticle');
    Route::get('/catalog/{id}', 'CatalogsController@getCatalogArticles');
    Route::get('/tag/{id}', 'TagsController@getTagArticles');
    Route::post('/article/comment', 'CommentController@store');
    Route::get('/article/comment/delete/{id}', 'CommentController@deleteComment');
    Route::get('/mail', 'IndexController@mail');
});
