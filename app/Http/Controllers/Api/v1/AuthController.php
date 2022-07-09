<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\Token;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{

  public function register(Request $request)
  {
      $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password)
      ]);
      return response(['message' => 'success','user' => $user]);
  }



  public function login(Request $request)
  {
    $user = User::where('email', '=', $request->email)
                        ->first();
    if($user){
      $obj = $user->createToken('API Token');
      $tokenParts = explode(".", $obj->accessToken);
      $tokenPayload = base64_decode($tokenParts[1]);
      $jwtPayload = json_decode($tokenPayload);
      $tokenId = $jwtPayload->jti;
      $user = Token::find($tokenId)->user;
  
      return response(['token' => $tokenId, 'user' => $user]);
    }
    return response(['message' => 'Error']);
   
  }
}
