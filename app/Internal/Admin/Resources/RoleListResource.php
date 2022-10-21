<?php

namespace App\Internal\Admin\Resources;

use App\Foundation\Resources\JsonResource;
use App\Models\Role;

/**
 * 角色列表
 * @author buxin
 * @date 2022-04-10
 * @package App\Internal\Role\Resources
 *
 * @property Role resource
 */
class RoleListResource extends JsonResource
{
    /**
     * Func toArray
     * @author buxin
     * @date 2022-04-22
     * @param $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->resource->id,
            'name' => $this->resource->name, // 名称
            'description' => $this->resource->description, // 描述
            'created_at' => $this->resource->created_at->format('Y-m-d H:i'),
            'updated_at' => $this->resource->updated_at->format('Y-m-d H:i'),
        ];
    }
}
