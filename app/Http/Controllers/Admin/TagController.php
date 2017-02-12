<?php

namespace App\Http\Controllers\Admin;

use App\Tag;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TagController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
	public function desk()
	{
    	return view('tags.index');
	}

    public function index()
    {
        $response['tags'] = Tag::paginate(10);

    	return $response;
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'slug' => 'required|alpha_dash|unique:tags',
        ]);

        $tag = Tag::create([
            'name' => $request->input('name'),
            'slug' => $request->input('slug'),
        ]);

        if($tag->id) {
            $response['error'] = false;
            $response['tag'] = $tag;
        } else {
            $response['error'] = true;        
        }

        return $response;
    }

    public function update(Request $request, $id)
    {
        $tag = Tag::findOrFail($id);

        $this->validate($request, [
            'name' => 'required',
            'slug' => 'required|alpha_dash',
        ]);

        $tag->name = $request->input('name');
        $tag->slug = $request->input('slug');
        $tag->save();

        $response['error'] = false;
        $response['tag'] = $tag;

        return $response;
    }

    public function destroy($id)
    {
        $tag = Tag::findOrFail($id);
        $tag->delete();

        $response['error'] = false;

        return $response;
    }
}
