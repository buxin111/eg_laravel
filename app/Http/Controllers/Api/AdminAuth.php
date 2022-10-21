<?php

namespace App\Http\Controllers\Api;

use App\Foundation\Support\Auth;
use App\Http\Controllers\ApiController;
use Illuminate\Auth\AuthenticationException;

class AdminAuth extends ApiController
{
    /**
     * 获取登录用户
     * @author buxin
     * @date 2022-04-03
     * @throws
     * @return \App\Models\Admin|\Illuminate\Contracts\Auth\Authenticatable
     */
    protected function auth()
    {
        // 如果没有登录就抛出异常
        throw_unless(Auth::admin()->user(), AuthenticationException::class);

        return Auth::admin()->user();
    }

    /**
     * 获取登录人ID
     * @author buxin
     * @date 2022-04-03
     * @return int
     */
    protected function getAdminId(): int
    {
        return $this->auth()->id;
    }
}
