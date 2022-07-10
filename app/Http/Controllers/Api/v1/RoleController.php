<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Role;


class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::orderby('id', 'desc')->get();

        return response()->json($roles);
    }

  
}
