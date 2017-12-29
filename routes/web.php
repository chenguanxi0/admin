<?php

//后台首页
Route::get('/','AdminController@index');

//Excel操作
Route::get('excel/export','ExcelController@export');
Route::post('excel/import','ExcelController@import');
Route::get('search','ProductController@search');


//产品管理模块
Route::group(['prefix' => 'products'], function () {
    //产品品牌   brand
    Route::get('brand','ProductController@brand');
//产品分类   category

//产品列表   list
    Route::get('list','ProductController@productsList');
    Route::post('list','ProductController@listRes');
    Route::post('ajax/language','ProductController@ajaxRes');
//产品详情   detail
    Route::get('{model}/{language_id}','ProductController@detail');
//创建产品
    Route::any('store','ProductController@store');
//更新产品
    Route::post('{model}/{language_id}/update','ProductController@update');
//删除产品
    Route::get('{model}/{language_id}/delete','ProductController@delete');
});


//工具
Route::group(['prefix' => 'tool'], function (){
    Route::get('/','ToolController@index');
    Route::any('uploads', 'ToolController@uploadImages');
    Route::any('category', 'ToolController@category');
    Route::any('res', 'ToolController@res');
    Route::get('eadme', 'ToolController@readme');
    Route::get('commit', 'ToolController@commit');
    Route::get('backupsql', 'ToolController@backupsql');
    Route::get('backupbtn', 'ToolController@backupbtn');
    Route::any('brand/add', 'ToolController@brandAdd');
});

//分类管理
Route::group(['prefix' => 'categorys'], function () {
    Route::get('/','CategoryController@index');
    //添加分类
    Route::any('add','CategoryController@add');
    Route::post('rename', 'CategoryController@rename');
});

//评论管理
Route::group(['prefix' => 'commits'], function () {
    Route::get('/','CommitController@index');
//添加评论
    Route::any('add','CommitController@add');
});


//网站管理
Route::group(['prefix' => 'webs'], function () {
//新建网站信息
    Route::any('/add', 'WebController@add');

});