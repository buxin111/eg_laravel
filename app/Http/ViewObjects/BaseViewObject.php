<?php

namespace App\Http\ViewObjects;

use App\Foundation\Support\Response;

abstract class BaseViewObject
{
    /**
     * @author wangzh
     * @date 2022-04-18
     * @param ...$parameters
     * @return \Illuminate\Http\JsonResponse| mixed
     */
    public static function make(...$parameters)
    {
        $object = (new static(...$parameters));

        $response = $object->toResponse(); // 获取返回结果

        // 如果是数组就转化下
        return is_array($response) ? Response::successWithData($response) : $response;
    }

    abstract public function toResponse();
}
