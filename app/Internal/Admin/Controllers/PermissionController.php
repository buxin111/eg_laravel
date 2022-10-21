<?php

namespace App\Internal\Admin\Controllers;

use App\Http\Controllers\Api\AdminAuth;
use App\Internal\Admin\Requests\PermissionCreateRequest;
use App\Internal\Admin\Requests\PermissionEditRequest;
use App\Internal\Admin\Resources\PermissionForTopLevelResource;
use App\Internal\Admin\Resources\PermissionListResource;
use App\Internal\Admin\Services\PermissionService;

/**
 * @author buxin
 * @date 2022-04-23
 * @package App\Internal\Admin\Controllers
 */
class PermissionController extends AdminAuth
{

    private PermissionService $permissionService;

    /**
     * @param PermissionService $permissionService
     */
    public function __construct(PermissionService $permissionService)
    {
        $this->permissionService = $permissionService;
    }

    /**
     * 后台菜单列表
     * @author buxin
     * @date 2022-04-25
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function lists()
    {
        $list = $this->permissionService->getAllPermission();

        return PermissionListResource::collection($list);
    }

    /**
     * 获取顶级权限
     * @author buxin
     * @date 2022-04-25
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function topLevel()
    {
        $list = $this->permissionService->getTopLevelPermission();

        return PermissionForTopLevelResource::collection($list);
    }

    /**
     * 添加权限菜单
     * @author buxin
     * @date 2022-04-25
     * @param PermissionCreateRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(PermissionCreateRequest $request)
    {
        $this->permissionService->createPermission($request->getSafeData());

        return $this->success();
    }

    /**
     * 修改权限菜单
     * @author buxin
     * @date 2022-04-26
     * @param PermissionEditRequest $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit(PermissionEditRequest $request, int $id)
    {
        $this->permissionService->editPermission($id, $request->getSafeData());

        return $this->success();
    }

    /**
     * 删除权限菜单
     * @author buxin
     * @date 2022-04-26
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(int $id)
    {
        $this->permissionService->deletePermission($id);

        return $this->success();
    }

    public function info(int $id)
    {
        $info = $this->permissionService->findOnePermissionById($id);
    }


}
