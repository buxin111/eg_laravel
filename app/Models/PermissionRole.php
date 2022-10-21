<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class PermissionRole extends Pivot
{
    /**
     * @var string $table
     */
    protected $table = 'permission_role';

}
