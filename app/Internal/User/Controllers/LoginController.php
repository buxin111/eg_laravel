<?php

namespace App\Internal\User\Controllers;

use App\Foundation\Support\Response;
use App\Http\Controllers\Api\UserAuth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends UserAuth
{
    /**
     * 登录
     * @author buxin
     * @date 2022-04-03
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function authenticate(Request $request)
    {
        $credentials = $request->only('mobile', 'password');

        /***
         * @see \App\Foundation\Auth\RedisTokenGuard::login
         */
        if ($token = Auth::guard('api')->attempt($credentials)) {
            // 认证通过．．．
            return Response::successWithData(['token' => $token], '登录成功');
        }

        return Response::failedWithData('登录失败，请稍后重试!', ['token' => '']);
    }
}
