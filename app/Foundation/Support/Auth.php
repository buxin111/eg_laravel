<?php

namespace App\Foundation\Support;

use Illuminate\Support\Facades\Auth as AuthFacades;

/**
 * Class Auth
 * @author wangzh
 * @date 2022-02-24
 * @package App\Foundation\Support
 *
 * @method static \Illuminate\Contracts\Auth\Guard|\Illuminate\Contracts\Auth\StatefulGuard api()
 * @method static \Illuminate\Contracts\Auth\Guard|\Illuminate\Contracts\Auth\StatefulGuard admin()
 */
class Auth
{
    /**
     * Func __callStatic
     * @author wangzh
     * @date 2022-02-24
     * @param $method
     * @param $parameters
     * @return \Illuminate\Contracts\Auth\Guard|\Illuminate\Contracts\Auth\StatefulGuard
     */
    public static function __callStatic($method, $parameters = null)
    {
        return AuthFacades::guard($method);
    }
}
