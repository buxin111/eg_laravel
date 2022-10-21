<?php

namespace App\Internal\Admin\Resources;

use App\Foundation\Resources\JsonResource;
use App\Models\Permission;

/**
 * 管理后台的菜单列表
 * @author buxin
 * @date 2022-04-25
 * @package App\Internal\Admin\Resources
 *
 * @property-read Permission resource
 */
class PermissionListResource extends JsonResource
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
            'level_path' => $this->resource->level_path,
            'list_order' => $this->resource->list_order,
            'status' => $this->resource->status,
            'redirect' => $this->resource->redirect,
            'path' => $this->resource->path,
            'component' => $this->resource->component,
            'meta_hide_in_bread' => $this->resource->meta_hide_in_bread,
            'meta_hide_in_menu' => $this->resource->meta_hide_in_menu,
            'meta_icon' => $this->resource->meta_icon,
            'meta_no_cache' => $this->resource->meta_no_cache,
            'meta_title' => $this->resource->meta_title,
            'children' => $this->resource->children,
            'parent_id' => $this->resource->parent_id,
        ];
    }

}
