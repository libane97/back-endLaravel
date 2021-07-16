<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{


    public function index(){
         $users = User::all();
         $users->makeHidden(['created_at','updated_at','email_verified_at','Role_id']);
         foreach ($users as $user)
            $user->roles =  $user->roles =  $user->roles->makeHidden(['created_at','updated_at']);
         return response()->json(['user'=> $users]);
    }

    public function register(Request $request)
    {
        $data = $request->all();
        $validatedData = Validator::make($data,$this->dataValidation());
        if ($validatedData->fails()){
            return response()->json([ 'error' => 'Contrainte de donnee'], 510);
        }else{
            $data['password'] = bcrypt($request->password);

            $user = User::create($data);
            $user->token = $this->generateToken($user);
           // return response()->json([ 'user' => $user], 200);
            return response()->json([
                'success' => 'le utilisateur à ete crée avec success',
                'user'=> $user
            ], 200);
        }
    }

     private  function generateToken($user)
     {
       return  $user->createToken('authTokenEcommerce')->accessToken;
     }


     public function login(Request $request)
     {
         $loginData = $request->validate([
             'name' => 'required',
             'password' => 'required'
         ]);

         if (!Auth::attempt($loginData)) {
             return response()->json(['error' => 'Username ou Mot de passe est incorrect !!!'],401);
         }

         $user = auth()->user();
         $user->roles = $user->roles->makeHidden(['created_at','id','updated_at','id']);
         $user->access_token = $this->generateToken($user);
         $user->makeHidden(['created_at','updated_at','email_verified_at','Role_id']);
         return response()->json([ 'user' => $user], 200);
     }

     public function logout()
     {
            $user = User::findOrFail(Auth::guard('api')->id());
            if ($user) {
              //  $user->logout($user);
                return response()->json(['message' => 'User deconnecter avec success'], 200);
            }
            return response()->json(['error'=>'Invalid']);

     }

     public function destroy(User $user){
          $user = User::find($user->id);
          $user->delete();
          return response()->json([$user]);
     }


     public function update(Request $request, User $user)
        {
            $user = User::find($user->id);
            $data = $request->all();
            $user->name = $data['name'];
            $user->email = $data['email'];
            $user->telephone = $data['telephone'];
            $user->address = $data['address'];
            $user->Role_id = $data['Role_id'];
            $user->password = bcrypt($data['password']);
            $user->save();
            $user->token = $this->generateToken($user);
            $user->roles = $user->roles->makeHidden(['created_at','id','updated_at']);
            $user->makeHidden(['created_at','updated_at','Role_id','email_verified_at']);
            return response()->json(['success' => 'le utilisateur à ete modifier avec success' , 'user' => $user]);
        }


     private function dataValidation(){
             $validatedData = array(
                'name' => 'required|max:55',
                'email' => 'email|required|unique:users',
                'telephone' => 'required',
                'address' => 'required|string',
                'password' => 'required',
                'Role_id' => 'required',
            );

            return $validatedData;
     }
}
