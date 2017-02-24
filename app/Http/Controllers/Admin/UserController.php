<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
    	return User::paginate(10);
    }

    public function store(Request $request)
    {
    	$this->validate($request, [
    		'name' => 'required',
    		'email' => 'required|email|unique:users',
    		'password' => 'required|min:6|max:16'
		]);

		$user = User::create([
					'name' => $request->input('name'),
					'email' => $request->input('email'),
					'password' => bcrypt($request->input('password')),
				]);

		if($user->id) {
			$response['error'] = false;
            $response['user'] = $user;
		} else {
			$response['error'] = true;
		}

		return response()->json($response);
    }

    public function edit($id)
    {
    	return User::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
    	$this->validate($request, [
    		'name' => 'required',
    		'email' => 'required|email',
    		'password' => 'nullable|min:6|max:16'
		]);

		$user = User::findOrFail($id);
		$user->name = $request->input('name');
		$user->email = $request->input('email');
		if($request->input('password') != "" && !is_null($request->input('password'))) {
			$user->password = bcrypt($request->input('password'));
		}
		$user->save();

		$response['error'] = false;
        $response['user'] = $user;

		return response()->json($response);
    }

    public function destroy($id)
    {
		$user = User::findOrFail($id);
		$user->delete();

        $response['error'] = false;

		return response()->json($response);
    }
}
