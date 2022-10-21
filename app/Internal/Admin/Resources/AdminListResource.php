<?php

namespace App\Internal\Admin\Resources;

use App\Foundation\Resources\JsonResource;
use App\Models\Admin;

/**
 * 管理员列表
 * @author buxin
 * @date 2022-04-03
 * @package App\Internal\Admin\Resources
 *
 * @property Admin resource
 */
class AdminListResource extends JsonResource
{

    /**
     * Func toArray
     * @author buxin
     * @date 2022-04-24
     * @param $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->resource->id,
            'username' => $this->resource->username, // 用户名
            'name' => $this->resource->name, // 名称
            'avatar' => $this->resource->avatar, // 头像
            'introduce' => $this->resource->introduce, // 介绍
            'created_at' => $this->resource->created_at->format('Y-m-d H:i'),
            'updated_at' => $this->resource->updated_at->format('Y-m-d H:i'),
            'roles' => ['admin'],
        ];
    }
}
