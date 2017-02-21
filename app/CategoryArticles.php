<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoryArticles extends Model
{
    protected $fillable = [
    	'category_id', 'article_id',
    ];

    public function category()
    {
    	return $this->hasOne('App\Category', 'id', 'category_id');
    }

    public function article()
    {
    	return $this->hasOne('App\Article', 'id', 'article_id');
    }
}
