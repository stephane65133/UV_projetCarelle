<?php

namespace App\Http\Controllers;
use Mail;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Invitation;
use App\Group;
use App\UserGroup;
use App\User;
use App\Http\Controllers\Controller;


class InvitationController extends Controller
{
    //
    public function has_gnerate(){
        $caracteres = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $longueurMax = strlen($caracteres);
        $chaineAleatoire = '';
         for ($i = 0; $i < 256; $i++)
         {
         $chaineAleatoire .= $caracteres[rand(0, $longueurMax - 1)];
         }
         return $chaineAleatoire;
    }
    public function add(Request $request){
        $request->validate([
            'sender_id' => 'required',
            'receiver_id' => 'required',
            'group_id' => 'required',
            //'status' => 'required',
        ]);
        
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
 //                              l'emetteur doit etre differnet du destinataire ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~       
         
        if($request['sender_id']==$request['receiver_id']){
        	abort(400,'sender and receiver must be different');
        }
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        $data = $request->all();
        $data['hash']=$this->has_gnerate();
        $exist=UserGroup::whereGroup_id($data['group_id'])->whereUser_id($data['receiver_id'])->first();
          
            if ($exist!=null) {
               return response()->json([
                    'message' => 'user already exist in group'
                ], 400);
            }
 //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~       

        $invitation = Invitation::create($data);
 //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
 //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~       
            
            $group = Group::whereId($data['group_id'])->first();
            $recei=User::whereId($data['receiver_id'])->first();
            $dat = ['name'=>$recei->first_name,
                 'group'=>$group->name,
                  'sender'=>$receiv=User::whereId($data['sender_id'])->first()->first_name,
                   'link'=>url('/').'/api/'.$data['sender_id'].'/invitations/'.$data['receiver_id'].'/group/'.$data['group_id'].'/'.$data['hash']
              ];
          //return $data;
              $mail=$recei->email;
          Mail::send('mail', $dat, function($message) use ($mail){
                         $message->to($mail, 'stephane')->subject('V_CAM Team');
                         $message->from('stephanetamafo1@gmail.com','V_CAM Team');
                    });
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~`~~~~~~~~~~~~        
        return response()->json($invitation);
    }

    public function get(){
        return Invitation::all();
    }

    public function find($id){
        return Invitation::findOrFail($id);
    }

    public function update(Request $request,$id){
        $inv=Invitation::findOrFail($id);
        return $inv->update($request->all());
    }

    public function delete($id){
        $inv=Invitation::findOrFail($id);
        return $inv->delete();
    }

    public function valid($id1,$id2,$id3,$id){
        //return $id;
        $invitation = Invitation::whereGroup_id($id3)->whereSender_id($id1)->whereReceiver_id($id2)->whereHash($id)->first();
        
        $inv=['status'=>"ACCEPTED",
              'sender_id'=>$invitation->sender_id,
              'receiver_id'=>$invitation->receiver_id,
              'group_id'=>$invitation->group_id,
              'hash'=>$invitation->hash
            ];
        $ug=['group_id'=>$invitation['group_id'],
            'user_id'=>$invitation['receiver_id']
            ];
        $data = UserGroup::create($ug);
        $dt=Invitation::whereHash($id)->update($inv);
        return view('accep');
   }


}

