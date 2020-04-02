<?php

use think\Route;

//获取验证码
Route::get('code/:phone/:is_exist','api/code/get_code');

/***
 * 用户接口
 */
//用户注册
Route::post('user/register','api/user/register');

//用户登录
Route::post('user/login','api/user/login');

//获取登录用户
Route::get('user/user_info','api/user/user_info');

//用户修改密码
Route::post('user/change_pwd','api/user/change_pwd');

//用户修改收货地址
Route::post('user/receiving_address','api/user/receiving_address');

/***
 * 商品接口
 */
//获取分类列表
Route::get('book/get_cate','api/book/get_cate');

//获取商品信息
Route::post('book/get_book','api/book/get_book');

//获取热卖商品信息
Route::get('book/hot_book','api/book/hot_book');

//获取导航栏信息
Route::get('book/navigation_bar','api/book/navigation_bar');

//获取商品详情
Route::post('book/book_details','api/book/book_details');


/***
 * 购物车相关
 */
//添加商品至购物车
Route::post('cart/add_to_cart','api/cart/add_to_cart');

//查看购物车详情
Route::get('cart/cart_details','api/cart/cart_details');

//删除购物车商品
Route::post('cart/clear_cart','api/cart/clear_cart');

//查看购物车数量
Route::get('cart/get_cart_items','api/cart/get_cart_items');

/***
 * 订单相关
 */
//单个商品购买
Route::post('order/generate_order','api/order/generate_order');

//多个商品购买,购物车购买
Route::get('order/cart_purchase','api/order/cart_purchase');

//查看订单列表
Route::get('order/get_order_list','api/order/get_order_list');

//查看订单详情
Route::post('order/order_details','api/order/order_details');
