<?php

namespace App;

use App\Traits\PreMethods;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Mockery\Exception;

class Post extends Base
{
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

    public function beforeDelete()
    {
        $created_at = $this->created_at;
        if($created_at->diffInMinutes(Carbon::now()) >= 60){
            throw new Exception('One hour is passed');
        }

    }

}
