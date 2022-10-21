<?php

namespace App\Internal\Admin\Requests;

use App\Http\Requests\BaseFormRequest;

/**
 * 创建角色
 * @author buxin
 * @date 2022-04-26
 * @package App\Internal\Admin\Requests
 *
 * @property string name 角色名称
 * @property string description 角色描述
 * @property array permission_ids 角色id
 */
class RoleCreateRequest extends BaseFormRequest
{

    /**
     * Func rules
     * @author buxin
     * @date 2022-04-26
     * @return string[][]
     */
    public function rules(): array
    {
        return [
            'name' => ['required'],
            'permission_ids' => ['required', 'array'],
            'permission_ids.*' => ['integer']
        ];
    }

    /**
     * Func messages
     * @author buxin
     * @date 2022-04-27
     * @return string[]
     */
    public function messages()
    {
        return [
            'name.required' => '角色名称必填',
            'permission_ids.required' => '权限id必填',
            'permission_ids.*.integer' => '权限id元素必须都是整数',
        ];
    }

    /**
     * Func getName
     * @author buxin
     * @date 2022-04-27
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Func getDescription
     * @author buxin
     * @date 2022-04-27
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * Func getPermissionIds
     * @author buxin
     * @date 2022-04-27
     * @return array
     */
    public function getPermissionIds(): array
    {
        return $this->permission_ids;
    }
}
