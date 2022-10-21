<?php

namespace App\Internal\Admin\Requests;

use App\Http\Requests\BaseFormRequest;
use Illuminate\Validation\Rules\Password;

/**
 * Class AdminCreateRequest
 * @author buxin
 * @date 2022-04-24
 * @package App\Internal\Admin\Requests
 *
 * @property string name 登录的名称
 * @property string username 显示的昵称
 * @property string password 登录密码
 * @property array role_ids 角色ids
 */
class AdminCreateRequest extends BaseFormRequest
{
    /**
     * Func rules
     * @author buxin
     * @date 2022-04-24
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => ['required'],
            'username' => ['required'],
            'password' => ['required', 'confirmed', Password::min(8)],//todo min8的message（你知道需不需要）
            'role_ids' => ['required', 'array'],
            'role_ids.*' => ['integer']
        ];
    }

    /**
     * Func messages
     * @author buxin
     * @date 2022-04-24
     * @return string[]
     */
    public function messages(): array
    {
        return [
            'name.required' => '登录名称必填',
            'username.required' => '昵称必填',
            'password.required' => '密码必填',
            'password.confirmed' => '两次密码不正确',
            'role_ids.required' => '医生ID必填',
            'role_ids.array' => '医生ID必须是数组',
            'role_ids.*.integer' => '医生ID数组内必须为整数'
        ];
    }

    /**
     * 获取登录名称
     * @author buxin
     * @date 2022-04-24
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * 获取昵称
     * @author buxin
     * @date 2022-04-24
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * 获取密码
     * @author buxin
     * @date 2022-04-24
     * @return string
     */
    public function getPasswords(): string
    {
        return $this->password;
    }

    /**
     * 获取角色ids
     * @author buxin
     * @date 2022-04-24
     * @return array
     */
    public function getRoleIds(): array
    {
        return $this->role_ids;
    }


}
