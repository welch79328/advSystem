<?php

Route::any('admin/test', 'Admin\LoginController@test');
//後台登入
Route::any('admin/login', 'Admin\LoginController@login');

//'roles' => ['report', 'marketing', 'user', 'admin'],'middleware'=>['roles'],

Route::group(['prefix'=>'qu/admin','namespace'=>'Admin\Qu'], function (){

    Route::get('/', 'IndexController@index');
    //後台主頁面
    Route::get('info', 'IndexController@info');
    Route::get('quit', 'LoginController@quit');
    //使用者管理
    Route::resource('user', 'UserController');
    //登入狀態
    Route::any('loginlog', 'UserController@login');

    //功能頁
//    Route::resource('config', 'ConfigController');
//    Route::post('config/changecontent', 'ConfigController@changeContent');
//    Route::get('config/putfile', 'ConfigController@putFile');
//
//    Route::get('report', 'ReportController@index');
//    Route::any('reporttest', 'ReportController@test');
//    Route::any('reporttest2', 'ReportController@test2');
//
//    Route::get('layout', 'LayoutController@index');
//    Route::post('layout/changecontent', 'LayoutController@changeContent');
//    Route::any('select/case/layout', 'LayoutController@selectcase');


    Route::resource('questionnaire', 'QuestionnaireController');
    //出首頁圖
    Route::any('layout/create', 'LayoutController@create');
    Route::any('layout/store', 'LayoutController@store');
    Route::any('layout/demo', 'LayoutController@demo');
    Route::any('layout/{routerName}/imitation', 'LayoutController@imitation');
//    Route::any('router_/search', 'QuestionnaireController@search');
//
//    //分類
    Route::resource('gift', 'GiftController');
    Route::any('classification_changes/{cate_id}', 'CategoryController@classification_changes');
    Route::any('classification_changes_up', 'CategoryController@classification_changes_up');
    //分類修改


    Route::any('upload', 'CommonController@upload');
});
