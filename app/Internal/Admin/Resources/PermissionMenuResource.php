<?php

namespace App\Internal\Admin\Resources;

use App\Foundation\Resources\JsonResource;
use App\Models\Permission;

/**
 * 管理后台的菜单
 * @author buxin
 * @date 2022-04-24
 * @package App\Internal\Admin\Resources
 *
 * @property-read Permission resource
 */
class PermissionMenuResource extends JsonResource
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
            'name' => $this->resource->name,
            'path' => $this->resource->path,
            'component' => $this->resource->component,
            'meta' => [
                'hideInBread'=>  $this->resource->meta_hide_in_bread,
                'hideInMenu'=>  $this->resource->meta_hide_in_menu,
                'icon'=>  $this->resource->meta_icon,
                'noCache'=>  $this->resource->meta_no_cache,
                'title'=>  $this->resource->meta_title,
            ],
            'children' => $this->resource->children
        ];
    }

}
