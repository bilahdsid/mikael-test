<?php


namespace App\Traits;


use Illuminate\Database\Eloquent\Model;

trait PreMethods
{
    protected static function bootPreMethods()
    {
        //parent::boot();

        static::creating(function (Model $model) {
            $model->beforeCreate();
        });
//
//        static::created(function (Model $model) {
//            $model->afterCreate($params = []);
//        });
//
//        static::updated(function (Model $model) {
//            $model->afterUpdate();
//        });


        static::updating(function (Model $model) {
            $model->beforeUpdate();
        });
    }

    public function abc(){
        return "add";
    }

}