<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Shanmuga\LaravelEntrust\Models\EntrustRole;

/**
 * Class Role
 * @author buxin
 * @date 2022-04-10
 * @package App\Models
 *
 * @property integer id
 * @property string name 用户名
 * @property string description 描述
 * @property \Illuminate\Support\Carbon|string created_at 添加时间
 * @property \Illuminate\Support\Carbon|string updated_at 修改时间
 *
 * @property-read Permission[] | Collection permissions
 *
 * @method static \Illuminate\Database\Eloquent\Builder|static searchName(string $name)
 */

class Role extends Model
{
    /**
     * Func scopeSearchName
     * @author buxin
     * @date 2022-04-10
     * @param Builder $query
     * @param string|null $name
     * @return Builder
     */
    public function scopeSearchName($query,$name)
    {
        return $name ? $query->where('name','like',"%${name}%") : $query;
    }

    /**
     * Func permissions
     * @author buxin
     * @date 2022-04-26
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }
}
