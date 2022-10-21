<?php

namespace App\Internal\Admin\Services;


use App\Foundation\Exceptions\BizException;
use App\Models\Admin;
use App\Models\Permission;
use App\Models\Role;

/**
 * 权限 暂时只支持二级权限(菜单)
 * @author buxin
 * @date 2022-04-23
 * @package App\Internal\Admin\Services
 */
class PermissionService
{
    /**
     * 获取权限列表
     * @author buxin
     * @date 2022-04-24
     * @param Admin $user
     * @return array|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getPermissionList(Admin $user)
    {
        return $user->isSuper() ? $this->getAllEnablePermission() : $this->getCurrentRolePermission($user->roles);
    }

    /**
     * 获取所有可用的的权限
     * @author buxin
     * @date 2022-04-24
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getAllEnablePermission()
    {
        return Permission::queryEnable()->with('children')->get();
    }


    /**
     * 获取当前用户所有角色的权限
     * @author buxin
     * @date 2022-04-24
     * @param Role[] $roles
     */
    public function getCurrentRolePermission($roles)
    {
        $allPermissions = [];

        foreach ($roles as $role) {

            foreach ($role->permissions as $permission) {

                if (!isset($allPermissions[$permission->id])) {//只有不存在的菜单才会添加进去

                    $allPermissions[$permission->id] = $permission;

                }

            }
        }
        return $allPermissions;
    }

    /**
     * 获取所有的权限菜单
     * @author buxin
     * @date 2022-04-25
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getAllPermission()
    {
        return Permission::with('children')->get();
    }

    /**
     * 获取顶级权限菜单
     * @author buxin
     * @date 2022-04-25
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getTopLevelPermission()
    {
        return Permission::topLevel()->get();
    }

    /**
     * 添加权限菜单
     * @author buxin
     * @date 2022-04-26
     * @param array $requestData 添加的数据
     */
    public function createPermission(array $requestData)
    {
        /**
         * @var Permission $permission
         */
        $permission = Permission::query()->create($requestData);

        $permission->level_path = 0;

        $permission->save();
    }


    /**
     * 编辑权限菜单
     * @author buxin
     * @date 2022-04-26
     * @param int $id 修改数据的id
     * @param array $requestData 修改的数据
     * @return BizException|void
     */
    public function editPermission(int $id, array $requestData)
    {

        $permission = $this->findOnePermissionById($id);

        $requestData['level_path'] = 0;

        if ($permission->isTopPermission()) {

            if ($permission->isHasChildren()) {

                return new BizException('该用户下还有子集，禁止修改');

            }

            if ($permission->isSelectSelf()){

                return new BizException('禁止选择自己');

            }

        }else{

            $requestData['level_path'] .= $permission->parent_id;

        }

        $permission->update($requestData);

    }

    /**
     * 删除权限菜单
     * @author buxin
     * @date 2022-04-26
     * @param int $id
     * @return BizException|void
     */
    public function deletePermission(int $id)
    {
        $permission = $this->findOnePermissionById($id);

        if ($permission->isTopPermission()) {

            if ($permission->isHasChildren()) {

                return new BizException('该用户下还有子集，禁止修改');

            }

        }

        $permission->delete();
    }

    /**
     * Func findOnePermissionById
     * @author buxin
     * @date 2022-04-27
     * @param int $id
     * @return \Illuminate\Database\Eloquent\Builder|Permission
     */
    public function findOnePermissionById(int $id)
    {
        return Permission::query()->firstOrFail($id);
    }

}
