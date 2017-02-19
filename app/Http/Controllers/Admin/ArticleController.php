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

    public function desk()
    {
    	return view('posts.index');
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

    }

    public function destroy($id)
    {

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