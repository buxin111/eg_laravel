<?php

namespace App\Internal\Admin\Controllers;

use App\Http\Controllers\Api\AdminAuth;
use App\Internal\Admin\Requests\RoleCreateRequest;
use App\Internal\Admin\Requests\RoleEditRequest;
use App\Internal\Admin\Resources\RoleListResource;
use App\Internal\Admin\Services\RoleServices;
use Illuminate\Http\Request;

class RoleController extends AdminAuth
{
    private RoleServices $roleService;

    /**
     * @param RoleServices $roleServices
     */
    public function __construct(RoleServices $roleServices)
    {
        $this->roleService = $roleServices;
    }

    /**
     * 角色列表
     * @author buxin
     * @date 2022-04-04
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function lists(Request $request)
    {
        $name = $request->get('name');

        $list = $this->roleService->getAdminList($name);

        return RoleListResource::collection($list);
    }

    /**
     * 创建角色
     * @author buxin
     * @date 2022-04-27
     * @param RoleCreateRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(RoleCreateRequest $request)
    {
        $this->roleService->createRole($request->getName(), $request->getPermissionIds(), $request->getDescription());

        return $this->success();
    }

    /**
     * 修改角色
     * @author buxin
     * @date 2022-04-27
     * @param RoleEditRequest $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit(RoleEditRequest $request, int $id)
    {
        $this->roleService->editRole($id, $request->getName(), $request->getPermissionIds(), $request->getDescription());

        return $this->success();
    }

    /**
     * 删除角色
     * @author buxin
     * @date 2022-04-27
     * @param int $id
     */
    public function delete(int $id)
    {
        $this->roleService->deleteRole($id);

        $this->success();
    }

    public function info()
    {

    }

}
