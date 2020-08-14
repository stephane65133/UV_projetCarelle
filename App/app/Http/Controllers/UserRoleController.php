<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\UserRole;

class UserRoleController extends Controller
{
    //
    public function add(Request $request){
    	$request->validate([
            'user_id' => 'required',
            'role_id' => 'required'
        ]);

        $ur=UserRole::whereUserIdAndRoleId($request['user_id'],$request['role_id'])->first();
        //return $ur;
        if ($ur!=null) {
            abort(404,'User not found');
        }

        $data = $request->all();
        $ur = UserRole::create($data);
        return response()->json($ur);
    }

    public function get(){
        return UserRole::all();
    }

    public function find($id){
        return UserRole::findOrFail($id);
    }

    public function update(Request $request,$id){
        $ur = UserRole::findOrFail($id);
        return $ur->update($request->all());
    }

    public function delete($id){
        $ur = UserRole::findOrFail($id);
        return $ur->delete();
    }
}
