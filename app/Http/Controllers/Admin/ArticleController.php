<?php

namespace App\Http\Controllers\Admin;

use App\Article;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ArticleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
    	$articles = Article::with('categories')->paginate(10);

    	return $articles;
    }

    public function store(Request $request)
    {
    	$this->validate($request, [
    		'title' => 'required',
    		'content' => 'required',
    		'slug' => 'required|alpha_dash|unique:articles',
		]);

		$article = Article::create([
			'title' => $request->input('title'),
			'content' => $request->input('content'),
			'excerpt' => $request->input('excerpt'),
			'featured_image' => $request->input('featured_image'),
			'slug' => $request->input('slug'),
			'author_id' => \Auth::user()->id,
			'status' => $request->input('status'),
		]);

		if($article->id) {
			$categories = $request->input('categories');

			$tags = $request->input('tags');

			foreach ($categories as $category) {
				\App\CategoryArticles::firstOrCreate(['category_id' => $category, 'article_id' => $article->id]);
			}

			foreach ($tags as $tag) {
				\App\TagArticles::firstOrCreate(['tag_id' => $tag, 'article_id' => $article->id]);
			}

			$response['error'] = false;
            $response['article'] = $article;
		} else {
			$response['error'] = true;
		}

        return response()->json($response);

    }

    public function edit($id)
    {
        $response['article'] = Article::findOrFail($id);

        if(!is_null($response['article']->featured_image)) {            
            $response['article']['featured_image_url'] = asset('storage/featured_images/'.$response['article']->featured_image); 
        }

        $response['categories'] = $response['article']->categories()->pluck('category_id');

        $response['tags'] = $response['article']->tags()->pluck('tag_id');

        return $response;
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required',
            'content' => 'required',
            'slug' => 'required|alpha_dash',
        ]);

        $article = Article::findOrFail($id);
        $article->title = $request->input('title');
        $article->content = $request->input('content');
        $article->excerpt = $request->input('excerpt');
        $article->featured_image = $request->input('featured_image');
        $article->slug = $request->input('slug');
        $article->status = $request->input('status');
        $article->save();

        $categories = $request->input('categories');
        $tags = $request->input('tags');

        foreach ($categories as $category) {
            \App\CategoryArticles::firstOrCreate(['category_id' => $category, 'article_id' => $article->id]);
        }

        foreach ($tags as $tag) {
            \App\TagArticles::firstOrCreate(['tag_id' => $tag, 'article_id' => $article->id]);
        }

        \App\CategoryArticles::whereNotIn('category_id', $categories)
        ->where('article_id', $article->id)
        ->delete();

        \App\TagArticles::whereNotIn('tag_id', $tags)
        ->where('article_id', $article->id)
        ->delete();

        $response['error'] = false;

        return response()->json($response);

    }

    public function destroy($id)
    {
        $article = Article::findOrFail($id);

        $article->categories()->delete();
        $article->tags()->delete();
        $article->delete();

        $response['error'] = false;

        return response()->json($response);
    }

    public function fileUpload(Request $request)
    {
    	$this->validate($request, [
    		'featured_image' => 'image'
		]);

    	$file = $request->file('featured_image');

    	$filename = $file->getClientOriginalName();

    	$path = $file->storeAs('featured_images', $filename, 'public');

    	$response['path'] = asset('storage/'.$path);

    	$response['filename'] = $filename;

        return response()->json($response);
    }
}