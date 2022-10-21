<?php

namespace App\Internal\Admin\Requests;

use App\Http\Requests\BaseFormRequest;

/**
 * 登录接口
 * @author buxin
 * @date 2022-04-22
 * @package App\Internal\Admin\Requests
 *
 * @property string username 用户名称
 * @property string password 密码
 */
class LoginRequest extends BaseFormRequest
{
    /**
     * Func rule
     * @author buxin
     * @date 2022-04-22
     * @return string[][]
     */
    public function rules(): array
    {
        return [
            'username' => ['required'],
            'password' => ['required'],
        ];
    }

    /**
     * Func messages
     * @author buxin
     * @date 2022-04-22
     * @return string[]
     */
    public function messages(): array
    {
        return [
            'username.required' => '用户名必填',
            'password.required' => '密码必填',
        ];
    }

    /**
     * Func getUserName
     * @author buxin
     * @date 2022-04-22
     * @return string
     */
    public function getUserName(): string
    {
        return $this->username;
    }

    /**
     * Func getPasswords
     * @author buxin
     * @date 2022-04-22
     * @return string
     */
    public function getPasswords(): string
    {
        return $this->password;
    }

    /**
     * 获取拼接好的登录验证数据
     * @author buxin
     * @date 2022-04-22
     * @return array
     */
    public function getCredentials(): array
    {
        return [
            'username' => $this->username,
            'password' => $this->password
        ];
    }

}
