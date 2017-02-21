<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = [
    	'name', 'slug',
    ];

    public function articles()
    {
    	return $this->hasMany('App\TagArticles', 'tag_id', 'id')->with('article');
    }
}
