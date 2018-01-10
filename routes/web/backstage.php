<?php

Route::any('admin/login', 'Admin\LoginController@login');
Route::any('admin/logout', 'Admin\LoginController@logout');
Route::post('login_deal_with', 'Admin\LoginController@login_deal_with');
Route::any('test', 'Admin\LoginController@test');

Route::group(['middleware'=>['admin.login'],'prefix'=>'admin','namespace'=>'Admin'], function (){

    Route::get('index/{act}', 'IndexController@index');
    Route::get('member_add/{act}', 'IndexController@member_add');
    Route::post('member_deal_with', 'IndexController@member_deal_with');
    Route::get('member_up/{ma_id}/{act}', 'IndexController@member_up');
    Route::post('member_up_deal_with', 'IndexController@member_up_deal_with');
    Route::post('member_del', 'IndexController@member_del');

    Route::get('log/{act}', 'IndexController@log');
    Route::get('point/{act}', 'IndexController@point');

    Route::get('point_gift/{act}', 'PointsController@point_gift');
    Route::get('point_add/{act}', 'PointsController@point_add');
    Route::post('point_deal_with', 'PointsController@point_deal_with');
    Route::get('point_edit', 'PointsController@point_edit');
    Route::post('point_up_deal_with', 'PointsController@point_up_deal_with');
    Route::get('point2/{act}', 'PointsController@point2');


    Route::get('class/{act}', 'AdvertisementController@calss');
    Route::get('class_add/{act}', 'AdvertisementController@calss_add');
    Route::post('class_deal_with', 'AdvertisementController@class_deal_with');
    Route::get('class_up/{s_id}/{act}', 'AdvertisementController@class_up');
    Route::post('class_del', 'AdvertisementController@class_del');

    Route::get('banner/{act}', 'AdvertisementListController@banner');
    Route::get('banner_add/{act}', 'AdvertisementListController@banner_add');
    Route::get('banner_up/{a_id}/{act}', 'AdvertisementListController@banner_up');
    Route::post('banner_up_deal_with', 'AdvertisementListController@banner_up_deal_with');
    Route::post('banner_del', 'AdvertisementListController@banner_del');
    Route::post('banner_return', 'AdvertisementListController@banner_return');
    Route::post('banner_deal_with', 'AdvertisementListController@banner_deal_with');

    Route::any('upload', 'CommonController@upload');
    Route::any('upload/css', 'CommonController@upload_css');
});
