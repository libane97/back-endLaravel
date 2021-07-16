<?php

namespace App\Http\Controllers;

use App\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index(){
        $role = Role::all();
        $role->makeHidden(['created_at','id','updated_at']);
        return response()->json($role);
    }

    public function store(Request $request){
        $data = $request->validate([
             'profile' => 'required|min:3|max:20',
        ]);
        $role = new Role();
        $role->profile = $data['profile'];
        if ($role->save() === true) {
            $role->save();
            $object = response()->json(
             ['success' => 'Le role à ete crée avec success', 
             'data' => $role
            ],200);
        }else if($role->save() === false){
            $object = response()->json(
                ['error' => 'error veuillez recreer a nouveau !!!',
                'data' => $role
                ]
                ,500);
        }
        return $object;
    }


    public function show(Role $role){
    
         $roles = Role::find($role->id);
         $roles->makeHidden(['created_at','id','updated_at']);
         return response()->json(['data'=>$roles]);
    }


    public function update(Role $role, Request $request){
         $roles = Role::find($role->id); 
         $data = $request->validate([
              'profile' => 'required|min:3|max:20',
         ]);
         $roles->profile = $data['profile'];
         $roles->update();
         return response()->json($roles);
    }

    public function delete(Role $role){
        $roles = Role::find($role->id); 
        if ($role) {
            $object = $roles->delete();
        }else{
            $object = 'data non trouver !!!';
        }
        return response()->json($roles);
    }
}