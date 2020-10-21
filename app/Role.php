<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $guarded = [];

    public static $rules = [
        
    ];


    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'role_permission');
    }

    public function asignarPermisos($permission)
    {
        $this->permissions()->sync($permission, false);
    }

    
    public function users()
    {
        return $this->belongsToMany(User::class);
    }

}