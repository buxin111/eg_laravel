<?php

namespace App\Internal\Admin\Controllers;

use App\Foundation\Support\Response;
use App\Http\Controllers\Api\AdminAuth;
use App\Internal\Admin\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * 登录和退出
 * @author buxin
 * @date 2022-04-06
 * @package App\Internal\Admin\Controllers
 */
class LoginController extends AdminAuth
{
    /**
     * 登录
     * @author buxin
     * @date 2022-04-06
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function authenticate(LoginRequest $request)
    {
        $credentials = $request->getCredentials();
        /***
         * @see \App\Foundation\Auth\RedisTokenGuard::login
         */
        if ($token = Auth::guard('admin')->attempt($credentials)) {
            // 认证通过．．．
            return Response::successWithData(['token' => $token], '登录成功');
        }

        return Response::failedWithData('登录失败，请稍后重试!', ['token' => '']);
    }

    /**
     * 将用户退出应用程序。
     * @author buxin
     * @date 2022-04-06
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        /**
         * @see \App\Foundation\Auth\RedisTokenGuard::logout
         */
        Auth::guard('admin')->logout();

        return Response::successWithData([], '退出成功');
    }

}
