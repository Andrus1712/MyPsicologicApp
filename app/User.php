<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    public static $rules = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function asignarRol($role)
    {
        $this->roles()->sync($role, false);
    }

    public function tieneRol()
    {
        return $this->roles->flatten()->pluck('slug')->unique();
    }

    public function hasRole($role)
    {
        if ($this->roles()->where('name', $role)->first()) {
            return true;
        }
        return false;
    }

    public function havePermission($permission)
    {
        foreach ($this->roles as $role) {

            foreach ($role->permissions as $perm) {

                if ($perm->slug == $permission) {
                    return true;
                }
            }
        }

        return false;
        //return $this->roles;
    }
}
