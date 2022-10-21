<?php

namespace App\Internal\Admin\Requests;

use Illuminate\Validation\Rules\Password;

/**
 * 修改管理员
 * @author buxin
 * @date 2022-04-24
 * @package App\Internal\Admin\Requests
 */
class AdminEditRequest extends AdminCreateRequest
{
    /**
     * Func rules
     * @author buxin
     * @date 2022-04-24
     * @return array
     */
    public function rules(): array
    {
        $parent = parent::rules();

        $parent['password'] = ['required', 'confirmed', 'current_password', Password::min(8)];//todo min8的message（你知道需不需要）

        return $parent;
    }

    /**
     * Func messages
     * @author buxin
     * @date 2022-04-24
     * @return array
     */
    public function messages(): array
    {
        $parent = parent::messages();

        $parent['password.current_password'] = '当前密码和原密码不一致';

        return $parent;
    }

}
