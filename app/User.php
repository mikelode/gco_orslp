<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'gcousuario';
    protected $primaryKey = 'tusId';
    public $timestamps = false;
    public $remember_token = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function hasPermission($permission = null)
    {
        return !is_null($permission) && $this->checkPermission($permission);
    }

    protected function checkPermission($perm)
    {
        $permissions = $this->getAllPermissionsFromAllRoles();
        $permissionArray = is_array($perm) ? $perm : [$perm];

        return count(array_intersect($permissions, $permissionArray));
    }

    protected function getAllPermissionsFromAllRoles()
    {
        $permissions = $this->roles->load('permissions')->toArray();

        $permissionArray = array_unique(array_flatten(array_map(function($permission){
            if($permission['trolEnable'])
            {
                return array_pluck($permission, 'tsysId');
            }
            return null;
        }, $permissions)));

        return array_map('strtolower', $permissionArray);
    }

    public function roles()
    {
        return $this->hasMany('App\Models\Rol','trolIdUser','tusId');
    }
}
