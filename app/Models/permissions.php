<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 前台导航表
 * @author buxin
 * @date 2022-10-21
 * @package App\Models\permissions
 *
 * @property integer id 自增ID
 * @property string path 路径
 * @property string name 路由名称
 * @property string component 组件
 * @property integer parent_id 父级ID
 * @property string level_path 层级路径
 * @property string meta_title 菜单名称
 * @property string meta_icon 菜单图标
 * @property string meta_hide_in_bread 此级路由是否显示在面包屑中 1-是 2-否
 * @property string meta_hide_in_menu 次左侧菜单不会显示该页面选项 1-是 2-否
 * @property string meta_no_cache 切换标签不会缓存 1-是 2-否
 * @property integer list_order 排序
 * @property string redirect 重定向
 * @property string status 1-可用 2-不可用
 * @property string created_at 
 * @property string updated_at 
 *
 */

class permissions extends Model
{
    use HasFactory;
}
