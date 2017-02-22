<?php

namespace App\Http\Controllers;

use App\Article;
use Illuminate\Http\Request;

class BlogController extends Controller
{
	protected $theme = 'default';

    public function index(Request $request)
    {
    	$articles = new Article;

    	if($request->has('search')) {
    		$articles = $articles->quickSearch($request->input('search'));
    	}

    	$data['articles'] = $articles->where('status', 'published')->get();

    	return view('themes/'.$this->theme.'/home', $data);
    }

    public function article($slug)
    {
    	$data['article'] = Article::where('slug', $slug)->firstOrFail();

    	return view('themes/'.$this->theme.'/article', $data);
    }

    public function category($slug)
    {
    	$category = \App\Category::where('slug', $slug)->firstOrFail();

    	$data['articles'] = $category->articles;

    	return view('themes/'.$this->theme.'/articles', $data);
    }

    public function tag($slug)
    {
    	$tag = \App\Tag::where('slug', $slug)->firstOrFail();

    	$data['articles'] = $tag->articles;

    	return view('themes/'.$this->theme.'/articles', $data);
    }
}
