<?php

namespace App;

use App\Traits\PreMethods;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use PreMethods;



    //
    protected $guarded = [];

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }

    public function likes(){
        return $this->belongsToMany(User::class,'post_likes','post_id','user_id')->withTimestamps();
    }

    public function comments(){
        return $this->belongsToMany(User::class,'post_comments','post_id','user_id')->withTimestamps();
    }

//    public function beforeUpdate(){
//        return ($this);
//    }
}
