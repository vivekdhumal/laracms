<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
	public function desk()
	{
    	return view('categories.index');
	}

    public function index()
    {
        $response['categories'] = Category::with('parent')->paginate(10);

        $response['parent_categories'] = Category::where('parent', 0)->get();

        return $response;
    }

    public function allCategories()
    {
        $response['categories'] = Category::all();

        return $response;
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'slug' => 'required|alpha_dash|unique:categories',
        ]);

        $category = Category::create([
            'name' => $request->input('name'),
            'parent' => ($request->input('parent') != "") ? $request->input('parent') : 0,
            'slug' => $request->input('slug'),
        ]);

        if($category->id) {
            $response['error'] = false;
            $response['category'] = $category;
        } else {
            $response['error'] = true;        
        }

        return $response;
    }

    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $this->validate($request, [
            'name' => 'required',
            'slug' => 'required|alpha_dash',
        ]);

        $category->name = $request->input('name');
        $category->parent = ($request->input('parent') != "") ? $request->input('parent') : 0;
        $category->slug = $request->input('slug');
        $category->save();

        $response['error'] = false;
        $response['category'] = $category;

        return $response;
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        $response['error'] = false;

        return $response;
    }
}
