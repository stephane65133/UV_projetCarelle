<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UserGroup;

class UserGroupController extends Controller
{
    //
    public function add(Request $request){
    	
    	$request->validate([
            'user_id' => 'required',
            'group_id' => 'required'
        ]);
        $user=UserGroup::whereGroupIdAndUserId($request['group_id'],$request['user_id'])->first();
        if ($user!=null) {
             abort(404,'User not found');
        }
        $data = $request->all();
        $ug = UserGroup::create($data);
        return response()->json($ug);
    }

    public function get(){
        return UserGroup::all();
    }

    public function find($id){
        return UserGroup::findOrFail($id);
    }

    public function update(Request $request,$id){
        $ug = UserGroup::findOrFail($id);
        return $ug->update($request->all());
    }

    public function delete($id){
        $ug = UserGroup::findOrFail($id);
        return $ug->delete();
    }

    public function addAdmin($id,$id1){
        $ug=UserGroup::whereGroupIdAndUserId($id1,$id)->first();
        if ($ug==null) {
             abort(404,'User not found');
        }
        $update=[
            'group_id'=>$ug->group_id,
            'user_id'=>$ug->user_id,
            'is_admin'=>true
        ];
        //return $update;
        return $ug->update($update);
    }

    public function removeAdmin($id,$id1){
        $ug=UserGroup::whereGroupIdAndUserId($id1,$id)->first();
        if ($ug==null) {
             abort(404,'User not found');
        }
        $update=[
            'user_id'=>$ug->user_id,
            'group_id'=>$ug->group_id,
            'is_admin'=>'0'
        ];

        return $ug->update($update);
    }
}
