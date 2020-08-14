<?php

namespace App\Http\Controllers;
use Mail;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{

    public function key_gnerate(){
        $caracteres = '01234567abcdefABCDEF';
        $longueurMax = strlen($caracteres);
        $key = '';
         for ($i = 0; $i < 5; $i++)
         {
         $key .= $caracteres[rand(0, $longueurMax - 1)];
         }
         return $key;
    }
   
   

   public function add(Request $request){
        //return response()->json($request->all());
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|unique:users'
        ]);

        $key = "";


/*~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~*
  !!                                                l'unicite de la cle des utilsateurs                                                  !!
  ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~*/    $condition=true;
        while($condition){
            $key=$this->key_gnerate();
            $user = User::wherePassword($key)->first();
            if ($user == null) {
                $condition=false;
            }
        }
       

//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
        $data=$request->all();
        $data['password'] = bcrypt($key);
        
        if($file = $request->file('avatar')){
            $request->validate(['avatar'=>'image|mimes:jpeg,png,jpg,gif,svg']);
            $extension=$file->getClientOriginalExtension();
            $relativeDestination = "uploads/users";
            $destintionPath=public_path($relativeDestination);
            $safeName = str_replace(' ','_',$request->email).time().'.'.$extension;
            $file->move($destintionPath , $safeName);
            $data['avatar']=url("$relativeDestination/$safeName");
        }
        $user=User::create($data);

/*!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
  !!                                               envois du mot de passe par mail                                                        !!
  !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!*/
        $dat = ['name'=>$data['first_name'],
                   'password'=>'Vous avez ete ajouter dans notre site comme utilisater. Votre mot de pass est le suivant:  '.$key,
                   'link'=>url('/')
              ];
              $mail=$data['email'];
        Mail::send('user', $dat, function($message) use ($mail){
                         $message->to($mail, 'stephane')->subject('V_CAM Team');
                         $message->from('stephanetamafo1@gmail.com','V_CAM Team');
                    });
        return response()->json($user);
    }


//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    public function forget_pwd($id){
        $key ='';
        $condition=true;
        while($condition){
            $key=$this->key_gnerate();
            $user = User::wherePassword($key)->first();
            if ($user == null) {
                $condition=false;
            }
        }

        $user = User::whereEmail($id)->first();
        $us=[
            'first_name'=>$user->first_name,
            'last_name'=>$user->last_name,
            'email'=>$user->email,
            'password'=>bcrypt($key),
            'avatar'=>$user->avatar
        ];
        $response=$user->update($us);
        $dat = ['name'=>$user->first_name,
                'password'=>'Votre mot de passe a ete reinitialise. Votre mot de pass est le suivant:  '.$key,
               ];
              $mail=$user->email;
        Mail::send('pwdforget', $dat, function($message) use ($mail){
                        $message->to($mail, 'stephane')->subject('V_CAM Team');
                         $message->from('stephanetamafo1@gmail.com','V_CAM Team');
                    });
        return $response;
    }


//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    public function change_pwd(Request $request, $id){
        $request->validate([
            'password' => 'required',
        ]);
        $user = User::whereId($id)->first();
        //return $user;
        if($user==null){
            return ('Nout found');}
        $us=[
            'first_name'=>$user->first_name,
            'last_name'=>$user->last_name,
            'email'=>$user->email,
            'password'=>bcrypt($request['password']),
            'avatar'=>$user->avatar
        ];
        $response=$user->update($us);
        return $response;
    }
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    public function get(){
        return User::all();
    }

//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
     public function find($id){

        $user=User::find($id);
        if($user == null){
            abort(404,'User not found');
        }
        else{
            return response()->json($user);
        }
    }


//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    public function delete($id){
        $user=User::find($id);
        if($user == null){
            abort(404,'User not found');
        }
        $user->delete();
        return response()->json($user);
    }
    

//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    public function update(Request $request, $id){
      $user = User::find($id);
      if($user == null) {
        return response()->json([
          'message' => 'Unauthorized'
      ], 404);
    }
      $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required'

        ]);
        $data = $request->all();
        if($request['email']!=$user->email)
        {   
            $user1= User::whereEmail($request['email'])->first();
            if ($user1!=null) {
              return response()->json([
                'message' => 'email already exist'
            ], 400);
            }
            $data['email']=$request['email'];
        }


        if (isset($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        }
         

        if ($file = $request->file('avatar')) {
            $request->validate(['avatar' => 'image|mimes:jpeg,png,jpg,gif,svg,PNG']);
            $extension = $file->getClientOriginalExtension();
            $relativeDestination = "uploads/users";
            $destinationPath = public_path($relativeDestination);
            $safeName = str_replace(' ', '_', $user->name) . time() . '.' . $extension;
            $file->move($destinationPath, $safeName);
            $data['avatar'] = url("$relativeDestination/$safeName");
            //Delete old user image if exxists
            if ($user->avatar) {
                $oldImagePath = str_replace(url('/'), public_path(), $user->avatar);
                if (file_exists($oldImagePath)) {
                    @unlink($oldImagePath);
                }
            }
        }
        $user->update($data);
        return response()->json($data);
    }
}
