<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //explicitly tell laravel that this model uses the categories table in the db.
    protected $table = 'categories';

    public function posts() {
        //one to many relationship with Post model
        return $this->hasMany('App\Post');
    }
}
