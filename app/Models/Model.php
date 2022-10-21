<?php

namespace App\Models;

/**
 * 模型基类
 * @author buxin
 * @date 2022-04-04
 * @package App\Models
 *
 * @method \Illuminate\Pagination\LengthAwarePaginator autoSizePaginate(string $perPageName = "pageSize", array $columns = ['*'], string $pageName = 'page', int $page = null)

 */
class Model extends \Illuminate\Database\Eloquent\Model
{
    /**
     * 自定义静态分页
     * @author buxin
     * @date 2022-04-04
     * @param $builder
     * @param string $perPageName
     * @param array $columns
     * @param string $pageName
     * @param int|null $page
     * @return mixed
     */
    public function scopeAutoSizePaginate($builder, string $perPageName = "pageSize", array $columns = ['*'], string $pageName = 'page', int $page = null)
    {
        // 当前页数
        $perPage = (int)request($perPageName) ?: $builder->getModel()->getPerPage();

        return $builder->paginate($perPage, $columns, $pageName, $page);
    }

}
