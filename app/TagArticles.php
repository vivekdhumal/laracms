<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TagArticles extends Model
{
    protected $fillable = [
    	'tag_id', 'article_id',
    ];

    public function tag()
    {
    	return $this->hasOne('App\Tag', 'id', 'tag_id');
    }

    public function article()
    {
    	return $this->hasOne('App\Article', 'id', 'article_id');
    }
}
