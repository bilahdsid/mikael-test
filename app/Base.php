<?php

namespace App;

use App\Traits\PreMethods;
use Illuminate\Database\Eloquent\Model;

class Base extends Model
{
    use PreMethods;

    public function beforeUpdate(){
        return ($this);
    }

    public function afterCreate(){
        return ($this);
    }

    public function afterUpdate(){
        return ($this);
    }

    public function beforeCreate(){
        return ($this);
    }

    public function beforeDelete(){
        return $this;
    }



}
