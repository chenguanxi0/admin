<?php

//后台首页
Route::get('/','AdminController@index');

//Excel操作
Route::get('excel/export','ExcelController@export');
Route::post('excel/import','ExcelController@import');
Route::get('search','ProductController@search');


//产品管理模块

//产品品牌   brand
Route::get('/products/brand','ProductController@brand');
//产品分类   category

//产品列表   list
Route::get('/products/list','ProductController@productsList');
//产品详情   detail
Route::get('/products/{model}/{language_id}','ProductController@detail');

//创建产品
Route::any('/products/store','ProductController@store');

//更新产品
Route::post('/products/{model}/{language_id}/update','ProductController@update');
//删除产品
Route::get('/products/{model}/{language_id}/delete','ProductController@delete');

Route::get('/tool','AdminController@tool');