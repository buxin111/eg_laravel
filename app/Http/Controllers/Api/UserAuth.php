<?php

namespace App\Http\Controllers\Api;

use App\Foundation\Support\Auth;
use App\Http\Controllers\ApiController;
use Illuminate\Auth\AuthenticationException;

class UserAuth extends ApiController
{
    /**
     * 获取登录用户
     * @author buxin
     * @date 2022-04-03
     * @throws
     * @return \App\Models\User|\Illuminate\Contracts\Auth\Authenticatable
     */
    protected function auth()
    {
        // 如果没有登录就抛出异常
        throw_unless(Auth::api()->user(), AuthenticationException::class);

        return Auth::api()->user();
    }

    /**
     * 获取登录人ID
     * @author buxin
     * @date 2022-04-03
     * @return int
     */
    protected function getUserId(): int
    {
        return $this->auth()->id;
    }
}
