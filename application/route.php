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

//查看session
Route::post('user/look_session','api/user/look_session');

//用户修改密码
Route::post('user/change_pwd','api/user/change_pwd');


/***
 * 商品接口
 */
//获取分类列表
Route::get('book/get_cate','api/book/get_cate');

//获取商品信息
Route::post('book/get_book','api/book/get_book');

//获取热卖商品信息
Route::get('book/hot_book','api/book/hot_book');