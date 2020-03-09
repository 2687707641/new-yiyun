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