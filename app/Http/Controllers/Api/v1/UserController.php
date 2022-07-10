<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {

        $users = User::with('role')->orderby('id', 'desc')->get();
        return response()->json($users);
     
    }





    public function store(Request $request)
    {
        
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;
        $user->password = Hash::make($request->password);
        if($request->file('image'))
        {
        $image = $request->image;
        $image_name = $image->getClientOriginalName();
        $request->image->move(public_path('user-images'), $image_name);
        $user->image = $image_name;
        }

        $user->save();

        return response()->json([
            'status' => 'success',
            'shop'   => $user
        ]);
    }

    public function show($id)
    {
        $user = User::find($id);
        return response()->json($user);
    }


    public function detail($id)
    {
        $user = User::with('role')->find($id);
        return response()->json($user);
    }



    public function update(Request $request, $id)
    {
        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;

        if($request->file('image'))
        {
        $image = $request->image;
        $image_name = $image->getClientOriginalName();
        $request->image->move(public_path('user-images'), $image_name);
        $user->image = $image_name;
        }

        $user->update();
        return response()->json([
            'status' => 'success',
            'user'   => $user
        ]);
    }

    public function destroy($id)
    {
         $user = User::find($id);
         $user->delete();

         return response()->json('user successfully deleted!');
    }



    public function changePsw(Request $request,$id)
    {
        $user = User::findOrFail($id);
        $user->password = Hash::make($request->password);
        $user->update();
        return response()->json('user password changed!');
    }
   
}
