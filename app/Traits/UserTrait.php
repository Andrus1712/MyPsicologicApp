<?php 

namespace App\Traits;

trait UserTrait {


    //es: desde aqui
    //en: from here

    public function roles()
    {
        return $this->belongsToMany(Role::class);

    }

    


}