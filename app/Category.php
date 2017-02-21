<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
    	'name', 'parent', 'slug',
    ];

    public function parent()
    {
    	return $this->belongsTo(Category::class, 'parent');
    }

    public function articles()
    {
    	return $this->hasMany('App\CategoryArticles', 'category_id', 'id')->with('article');
    }
}
