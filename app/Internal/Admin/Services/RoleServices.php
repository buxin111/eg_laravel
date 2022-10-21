<?php

namespace App\Internal\Admin\Services;

use App\Models\Admin;
use App\Models\Role;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

/**
 * Class RoleServices
 * @author buxin
 * @date 2022-04-10
 * @package App\Internal\Admin\Services
 */
class RoleServices
{
    /**
     * 获取角色列表
     * @author buxin
     * @date 2022-04-10
     * @param string|null $name
     * @return LengthAwarePaginator
     */
    public function getAdminList($name)
    {
        return Role::searchName($name)->autoSizePaginate();
    }

    /**
     * 创建角色
     * @author buxin
     * @date 2022-04-27
     * @param string $name 角色名称
     * @param array $permissionIds 权限id
     * @param string|null $description 描述
     */
    public function createRole(string $name, array $permissionIds, $description)
    {
        DB::transaction(function () use ($name, $permissionIds, $description) {

            /**
             * @var Role $role 创建角色...
             */
            $role = Role::query()->create(compact('name', 'description'));

            //创建角色关联的权限
            $role->permissions()->attach($permissionIds);

        });
    }

    /**
     * 修改角色
     * @author buxin
     * @date 2022-04-27
     * @param int $id 修改的id
     * @param string $name 角色名称
     * @param array $permissionIds 权限id
     * @param string|null $description 角色描述
     */
    public function editRole(int $id, string $name, array $permissionIds, $description)
    {
        $role = $this->findOneRoleById($id);

        DB::transaction(function () use ($role, $name, $permissionIds, $description) {

            //移除角色关联的权限...
            $role->permissions()->detach($permissionIds);

            $role->update(compact('name', 'description'));

            //创建新的角色关联的权限...
            $role->permissions()->attach($permissionIds);

        });

    }

    /**
     * 删除角色
     * @author buxin
     * @date 2022-04-27
     * @param int $id
     */
    public function deleteRole(int $id)
    {

        $role = $this->findOneRoleById($id);

        DB::transaction(function () use ($role) {

            //移除角色关联的权限...
            $role->permissions()->detach($role->permissions->toArray());

            //删除角色信息
            $role->delete();

        });
    }

    /**
     * 通过id查找一个角色
     * @author buxin
     * @date 2022-04-27
     * @param int $id
     * @return \Illuminate\Database\Eloquent\Builder|Role
     */
    public function findOneRoleById(int $id)
    {
        return Role::query()->where('id', $id)->firstOrFail();
    }

}
