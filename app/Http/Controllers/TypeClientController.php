<?php

namespace App\Http\Controllers;

use App\TypeClient;
use DateTime;
use Illuminate\Http\Request;

class TypeClientController extends Controller
{

    public function index(){
         $typeclient = TypeClient::all();
         return response()->json($typeclient);
    }


    public function store(Request $request){
        $data = $this->validatedata($request);
        $typeclient = new TypeClient();     
        $typeclient->name = $data['name'];
        $typeclient->save();
        return response()->json(['Type'=>$typeclient]);
    }

    public function show(TypeClient $type){
         $types = TypeClient::find($type->id);
         $types->makeHidden(['created_at','updated_at']);
         return $types;
    }


    public function update(Request $request,$id)
    {
          $data = $this->ValidateData($request);
          $typeclient = TypeClient::find($id);
          $typeclient->name = $data['name'];
          $typeclient->updated_at = new DateTime();
          $typeclient->save();
          return response()->json(['success'=>'Type Client modifier avec success', 'Type Client'=>$typeclient]);
    }

    public function destroy(TypeClient $typeclient){
         $type = TypeClient::find($typeclient->id);
         $type->delete();
         return response()->json(['success'=>'Type client a ete supprime', 'type'=>$type]);
    }

    public function search($key){
         $typeclient = TypeClient::Where('name','LIKE',"%{$key}%")->get();
         $typeclient->makeHidden(['created_at','updated_at']);
         return $typeclient;
    }

    private function ValidateData(Request $request){
        $data = $request->validate([
            'name' => 'required|min:3|max:20',
        ]);
       return $data;
    }

}
