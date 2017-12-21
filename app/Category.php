<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categorys';
    public function childCategory() {
        return $this->hasMany('App\Category', 'parent_id', 'id');
    }

    public function allChildrenCategorys()
    {
        return $this->childCategory()->with('allChildrenCategorys');
    }
}
