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
Route::get('/test','GoodsController@test');
Route::get('/login','LoginController@login');//登录页面
Route::post('/sendLogin','LoginController@sendLogin');//发起登录
Route::post('/loginDo','LoginController@loginDo');//登录执行


Route::post('/goodsGo','GoodsController@goodsGo');//商品审核通过
Route::post('/goodsStop','GoodsController@goodsDown');//商品审核驳回

Route::middleware('login')->group(function (){
    Route::get('admin','AdminController@index');//后台主页
    Route::get('business','AdminController@business');//商家管理
    Route::get('goods_examine','AdminController@goods_examine');//商家管理 商品审核
    Route::get('orderlist','AdminController@orderlist');//订单列表
    Route::get('orderAccess','AdminController@orderAccess');//已结算订单列表
    Route::get('orderNoAccess','AdminController@orderNoAccess');//未结算订单列表

});



