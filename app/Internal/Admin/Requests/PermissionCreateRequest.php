<?php

namespace App\Internal\Admin\Requests;

use App\Http\Requests\BaseFormRequest;

/**
 * 权限菜单创建request
 * @author buxin
 * @date 2022-04-25
 * @package App\Internal\Admin\Requests
 *
 * @property string name 路由名称
 * @property string path 路径
 * @property string component 组件
 * @property integer parent_id 父级id
 * @property string meta_title 菜单名称
 * @property integer meta_hide_in_bread 此级路由是否显示在面包屑中 1-是 2-否
 * @property integer meta_hide_in_menu 次左侧菜单不会显示该页面选项 1-是 2-否
 * @property integer meta_no_cache 切换标签不会缓存 1-是 2-否
 * @property integer list_order 排序
 * @property string redirect 重定向
 * @property integer status 1-可用 2-不可用
 */
class PermissionCreateRequest extends BaseFormRequest
{
    /**
     * Func rules
     * @author buxin
     * @date 2022-04-25
     * @return string[][]
     */
    public function rules(): array
    {
        return [
            'name' => ['required'],
            'path' => ['required'],
            'component' => ['required'],
            'parent_id' => ['required', 'integer'],
            'meta_title' => ['required'],
            'meta_hide_in_bread' => ['required', 'in:1,2'],
            'meta_hide_in_menu' => ['required', 'in:1,2'],
            'meta_no_cache' => ['required', 'in:1,2'],
            'list_order' => ['required', 'integer'],
            'status' => ['required', 'in:1,2'],
        ];
    }

    /**
     * Func messages
     * @author buxin
     * @date 2022-04-25
     * @return string[]
     */
    public function messages(): array
    {
        return [
            'name.required' => '路由名称必填',
            'path.required' => '路径必填',
            'component.required' => '组件必填',
            'parent_id.required' => '父级id必填',
            'parent_id.integer' => '父级id必须为数字',
            'meta_title.required' => '菜单名称必填',
            'meta_hide_in_bread.required' => '此级路由是否显示在面包屑中必填',
            'meta_hide_in_bread.in' => '此级路由是否显示在面包屑中必1,2',
            'meta_hide_in_menu.required' => '次左侧菜单不会显示该页面选项必填',
            'meta_hide_in_menu.in' => '次左侧菜单不会显示该页面选项必1,2',
            'meta_no_cache.required' => '切换标签不会缓存必填',
            'meta_no_cache.in' => '切换标签不会缓存必1,2',
            'list_order.required' => '排序必填',
            'list_order.integer' => '排序必须为数字',
            'redirect.required' => '排序必填',
            'status.required' => '状态必填',
            'status.in' => '状态必1,2',
        ];
    }

    /**
     * 获取验证通过的数据
     * @author buxin
     * @date 2022-04-25
     * @return array
     */
    public function getSafeData(): array
    {
        return [
            'name' => $this->name,
            'path' => $this->path,
            'component' => $this->component,
            'parent_id' => $this->parent_id,
            'meta_title' => $this->meta_title,
            'meta_hide_in_bread' => $this->meta_hide_in_bread,
            'meta_hide_in_menu' => $this->meta_hide_in_menu,
            'meta_no_cache' => $this->meta_no_cache,
            'list_order' => $this->list_order,
            'redirect' => $this->redirect,
            'status' => $this->status,
        ];
    }

}
