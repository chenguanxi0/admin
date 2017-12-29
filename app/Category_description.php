<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category_description extends Model
{
    public function findCategory()
    {
       return $this->belongsTo('App\Category','category_id','id');
    }
}
