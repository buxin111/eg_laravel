<?php

/**
 * admin 模块路由
 */
use Illuminate\Support\Facades\Route;
use App\Internal\Admin\Controllers\LoginController;
use App\Internal\Admin\Controllers\AdminController;
use \App\Internal\Admin\Controllers\RoleController;

//::middleware('auth:admin')


Route::post('/login', [LoginController::class, 'authenticate']);//登录

Route::middleware('auth:admin')->post('/logout', [LoginController::class, 'logout']);//退出登录

// 用户模块
Route::prefix('admin')->group(function () {

    //管理员
    Route::prefix('admin')->group(function (){

        Route::get('/info', [AdminController::class, 'info']);//管理员信息

        Route::get('/list', [AdminController::class, 'lists']);//管理员列表

    });


    Route::get('/permission', [AdminController::class, 'permissions']);// 权限菜单

    // 角色
    Route::prefix('role')->group(function () {
        Route::get('/list', [RoleController::class, 'lists']);//角色列表
    });




});




