<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = [
    	'title', 'content', 'excerpt', 'featured_image', 'slug', 'author_id', 'status',
    ];

    public function categories()
    {
    	return $this->hasMany('App\CategoryArticles')->with('category');
    }

    public function tags()
    {
    	return $this->hasMany('App\TagArticles')->with('tag');
    }
}
