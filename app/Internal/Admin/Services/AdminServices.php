<?php

namespace App\Internal\Admin\Services;

use App\Models\Admin;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

/**
 * 管理员
 * @author buxin
 * @date 2022-04-10
 * @package App\Internal\Admin\Services
 */
class AdminServices
{
    /**
     * 管理员列表
     * @author buxin
     * @date 2022-04-10
     * @param int|null $pageSize 每页个数
     * @return LengthAwarePaginator
     */
    public function getAdminList($pageSize)
    {
        return Admin::query()->Paginate($pageSize ?: Admin::getModel()->getPerPage());
    }

    /**
     * 删除管理员
     * @author buxin
     * @date 2022-04-24
     * @param int $adminId
     */
    public function deleteAdmin(int $adminId)
    {
        Admin::query()->where('id', $adminId)->delete();
    }

    /**
     * 创建管理员
     * @author buxin
     * @date 2022-04-24
     * @param string $name 登录名称
     * @param string $username 昵称
     * @param string $password 密码
     * @param array $roleIds 角色ids
     */
    public function createAdmin(string $name, string $username, string $password, array $roleIds)
    {
        DB::transaction(function () use ($name, $username, $password, $roleIds) {
            /**
             * @var Admin $user
             */
            $user = Admin::query()->create([
                'name' => $name,
                'username' => $username,
                'password' => Hash::make($password)
            ]);

            //同步角色关联表...
            $user->roles()->attach($roleIds);
        });

    }

    /**
     * 修改管理员
     * @author buxin
     * @date 2022-04-24
     * @param int $id 修改的id
     * @param string $name 登录名称
     * @param string $username 昵称
     * @param string $password 密码
     * @param array $roleIds 选择的角色id
     */
    public function editAdmin(int $id, string $name, string $username, string $password, array $roleIds)
    {
        /**
         * @var Admin $user
         */
        $user = Admin::query()->where('id',$id)->firstOrFail();

        DB::transaction(function () use ($user, $name, $username, $password, $roleIds) {

            // 移除用户的所有角色...
            $user->roles()->detach();

            Admin::query()->where('id', $user->id)->update([
                'name' => $name,
                'username' => $username,
                'password' => Hash::make($password)
            ]);

            //同步角色关联表...
            $user->roles()->attach($roleIds);
        });

    }


}
