<?php

namespace App\Http\Controllers;

use App\Foundation\Support\Response;


/**
 * Api 基类
 * @author buxin
 * @date 2022-04-03
 * @package App\Http\Controllers\Api
 */
class ApiController extends Controller
{
    /**
     * 失败
     * @author wangzh
     * @date 2022-02-25
     * @param array|null|\ArrayObject| $data
     * @param string $msg
     * @return \Illuminate\Http\JsonResponse
     */
    public function success($data = null, string $msg = '操作成功!')
    {
        $data = is_null($data) ? new \ArrayObject() : $data;

        return Response::successWithData($data, $msg);
    }

    /**
     * 失败
     * @author buxin
     * @date 2022-04-03
     * @param string $msg
     * @param array|null|\ArrayObject|string[]|integer[] $data
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    public function error(string $msg, $data = null, int $code = Response::CODE_FAILED)
    {
        $data = is_null($data) ? new \ArrayObject() : $data;

        return Response::failedWithData($msg, $data, $code);
    }
}
