<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product_description extends Model
{
    //根据id获取语言的name
    public function languageName()
    {
       return $this->hasOne('App\Language','id','language_id');
    }
    public function product()
    {
       return $this->belongsTo('App\Product','product_model','model');
    }
}
