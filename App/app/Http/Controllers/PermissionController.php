<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Permission;
use App\User;

class PermissionController extends Controller
{
    //
    public function add(Request $request){
        //return $request->all();
        $request->validate([
            'name' => 'required|unique:permissions'
        ]);

        $data = $request->all();
        $permission = Permission::create($data);
        return response()->json($permission);
    }

    public function get(){
        return Permission::all();
    }

    public function find($id){
        return Permission::findOrFail($id);
    }

    public function update(Request $request,$id){
        $permission=Permission::findOrFail($id);
        return $permission->update($request->all());
    }

    public function delete($id){
        $permission=Permission::findOrFail($id);
        return $permission->delete();
    }

}
