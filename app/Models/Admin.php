<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * Class Admin
 * @author buxin
 * @date 2022-04-10
 * @package App\Models
 *
 *
 * @property integer id
 * @property string name 用户名
 * @property string username 名称
 * @property string avatar 头像
 * @property string email 邮箱
 * @property string email_verified_at 邮箱验证时间
 * @property string password 密码
 * @property string introduce 介绍
 * @property \Illuminate\Support\Carbon|string created_at 添加时间
 * @property \Illuminate\Support\Carbon|string updated_at 修改时间
 *
 * @property-read Role[] roles
 *
 * @method static self getModel()
 */
class Admin extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];



    /**
     * 用户所拥有的角色
     * @author buxin
     * @date 2022-04-24
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }


    /**
     * 判断当前用户是否为超级管理员
     * @author buxin
     * @date 2022-04-24
     * @return bool
     */
    public function isSuper(): bool
    {
        return $this->id == 1;
    }

}
