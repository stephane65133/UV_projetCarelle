<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\User;
use App\UserRole;
use App\Role;
use DB;

class AuthController extends Controller
{
    //
    public function login(Request $request) {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        
        $credentials = $request->only(['email', 'password']);
        if(!Auth::attempt($credentials))
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        
        $user = Auth::user();
        
        $tokenResult = $user->createToken('User Manager');
        $token = $tokenResult->token;
        $token->save();

        $permissions = array();
         
        foreach ($user->roles as $role) {
            $role->permissions;
        }
        $user->groupes;
        foreach ($user->groupes as $group) {
            $group->users;
        }
        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString(),
            'user' => $user,
            'permissions'=>$permissions,
            
        ]);
    }
    public function logout(){
        Auth::logout();
        return;
    }
}
