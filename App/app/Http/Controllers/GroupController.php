<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Group;
use App\UserGroup;

class GroupController extends Controller
{
    //
        public function users($id){
           return Group::find($id)->users;
       }

        public function add(Request $request){
        //return response()->json($request->all());
        $request->validate([
            'name' => 'required|unique:groups',
            'creator_id'=>'required'
        ]);



        /*$group=group::find($request['creator_id']);
        if($group == null){
            abort(404,'Not found sender group');
        }*/


         $data = $request->all();

         if($request->file('avatar')){
            $file = $request->file('avatar');
            $request->validate(['avatar'=>'image|mimes:jpeg,png,jpg,gif,svg']);
            $extension=$file->getClientOriginalExtension();
            $relativeDestination = "uploads/groups";
            $destintionPath=public_path($relativeDestination);
            $safeName = str_replace(' ','_',$request->email).time().'.'.$extension;
            $file->move($destintionPath , $safeName);
            $data['avatar']=url("$relativeDestination/$safeName");
        }
        
        $group = Group::create($data);
        $ug=[
         'user_id'=>$data['creator_id'],
         'group_id'=>$group['id'],
         'is_admin'=>true
        ];
        UserGroup::create($ug);
        return response()->json($group);
    }


    public function get(){
         return Group::all();
    }
    
     public function find($id){
        return Group::findOrFail($id);
    }

    public function update(Request $request,$id){

         $group=Group::findOrFail($id);
         $data = $request->all();

            if (!isset($data['name'])) {
                $data['name'] = $group->name;
            }

            if (!isset($data['description'])) {
                $data['description'] = $group->description;
            }


            $data['creator_id'] = $group->creator_id;

         if ($file = $request->file('avatar')) {
            $request->validate(['avatar' => 'image|mimes:jpeg,png,jpg,gif,svg,PNG']);
            $extension = $file->getClientOriginalExtension();
            $relativeDestination = "uploads/groups";
            $destinationPath = public_path($relativeDestination);
            $safeName = str_replace(' ', '_', $group->name) . time() . '.' . $extension;
            $file->move($destinationPath, $safeName);
            $data['avatar'] = url("$relativeDestination/$safeName");
            //Delete old group image if exxists
            if ($group->avatar) {
                $oldImagePath = str_replace(url('/'), public_path(), $group->avatar);
                if (file_exists($oldImagePath)) {
                    @unlink($oldImagePath);
                }
            }
        }
    $group->update($data);
    return response()->json($data);
    }

   
    public function delete($id){
        $group = Group::findOrFail($id);
        return $group->delete();
    }
}
