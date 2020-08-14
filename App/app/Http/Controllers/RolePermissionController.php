<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\RolePermission;

class RolePermissionController extends Controller
{
    //
    public function add(Request $request){
    	$request->validate([
            'permission_id' => 'required',
            'role_id' => 'required'
        ]);

        $rp = RolePermission::wherePermissionIdAndRoleId($request['permission_id'],$request['role_id'])->first();
        if($rp != null){
             abort(404,'User not found');
        }

        $data = $request->all();
        $rp = RolePermission::create($data);
        return response()->json($rp);
    }

    public function get(){
        return RolePermission::all();
    }

    public function find($id){
        return RolePermission::findOrFail($id);
    }

    public function update(Request $request,$id){
        $rp = RolePermission::findOrFail($id);
        return $rp->update($request->all());
    }

    public function delete($id){
        $rp = RolePermission::findOrFail($id);
        return $rp->delete();
    }
}
