<?php

namespace App\Internal\Admin\Controllers;

use App\Http\Controllers\Api\AdminAuth;
use App\Internal\Admin\Requests\AdminCreateRequest;
use App\Internal\Admin\Requests\AdminEditRequest;
use App\Internal\Admin\Resources\AdminListResource;
use App\Internal\Admin\Resources\PermissionMenuResource;
use App\Internal\Admin\Services\AdminServices;
use App\Internal\Admin\Services\PermissionService;
use App\Models\Admin;
use App\Models\Permission;
use App\Models\PermissionRole;
use Illuminate\Http\Request;


/**
 * Class UserController
 * @author buxin
 * @date 2022-04-03
 * @package App\Internal\User\Controllers
 */
class AdminController extends AdminAuth
{

    private AdminServices $adminService;

    private PermissionService $permissionService;

    /**
     * @param AdminServices $adminService
     * @param PermissionService $permission
     */
    public function __construct(AdminServices $adminService, PermissionService $permission)
    {
        $this->adminService = $adminService;
        $this->permissionService = $permission;
    }

    /**
     * 登录人信息
     * @author buxin
     * @date 2022-04-03
     * @return AdminListResource
     */
    public function info()
    {
        return new AdminListResource($this->auth());
    }

    /**
     * 管理员列表
     * @author buxin
     * @date 2022-04-04
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function lists(Request $request)
    {
        $pageSize = $request->get('pageSize');

        $list = $this->adminService->getAdminList($pageSize);

        return AdminListResource::collection($list);
    }

    /**
     * 删除管理员
     * @author buxin
     * @date 2022-04-24
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($id)
    {
        $this->adminService->deleteAdmin($id);

        return $this->success();
    }

    /**
     * 添加
     * @author buxin
     * @date 2022-04-24
     * @param AdminCreateRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(AdminCreateRequest $request)
    {
        $this->adminService->createAdmin($request->getName(), $request->getUsername(), $request->getPasswords(), $request->getRoleIds());

        return $this->success();
    }

    /**
     * 修改
     * @author buxin
     * @date 2022-04-24
     * @param AdminEditRequest $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit(AdminEditRequest $request, int $id)
    {
        $this->adminService->editAdmin($id, $request->getName(), $request->getUsername(), $request->getPasswords(), $request->getRoleIds());

        return $this->success();
    }

    /**
     * 权限-菜单列表
     * @author buxin
     * @date 2022-04-24
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function permissions()
    {

        $permissions = $this->permissionService->getPermissionList($this->auth());

        return PermissionMenuResource::collection($permissions);
    }
}
