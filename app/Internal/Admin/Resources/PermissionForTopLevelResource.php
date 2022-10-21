<?php

namespace App\Internal\Admin\Resources;

use App\Foundation\Resources\JsonResource;
use App\Models\Permission;

/**
 * 顶级权限 map 只需要 id name
 * @author buxin
 * @date 2022-04-25
 * @package App\Internal\Admin\Resources
 *
 * @property-read Permission resource
 */
class PermissionForTopLevelResource extends JsonResource
{
    /**
     * Func toArray
     * @author buxin
     * @date 2022-04-25
     * @param $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->resource->id,
            'name' => $this->resource->name,
        ];
    }

}
