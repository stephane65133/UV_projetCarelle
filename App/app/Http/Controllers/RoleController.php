<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Role;
use App\User;

class RoleController extends Controller
{
    //

    
    /*public function users($id){
           return Role::find($id)->users;
    }public function permissions($id){
           return Role::find($id)->permissions;
    }*/

    public function add(Request $request){
        $request->validate([
            'name' => 'required|unique:roles'
        ]);

        /*$user=User::find($request['creator_id']);
        if($user == null){
            abort(404,'Not found sender user');
        }*/

        $data = $request->all();
        $role = Role::create($data);
        return response()->json($role);
    }


    public function find($id){
         return Role::findOrFail($id);
    }

    public function get(){
        return Role::all();
    }

    public function delete($id){
       $role=Role::findOrFail($id);
       return $role->delete();
    }

    


    public function update(Request $request,$id){
        $role=Role::findOrFail($id);
        return $role->update($request->all());
    }

    
}
