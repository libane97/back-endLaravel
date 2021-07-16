<?php

namespace App\Http\Controllers;

use App\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ClientController extends Controller
{
    public function index(){
        $client = Client::all();
        $client = $client->load('type_client');
        $client->makeHidden(['type_client_id','created_at','updated_at']);
        foreach ($client as $clients){
          $clients->type_client   =  $clients->type_client->makeHidden(['created_at','updated_at']);
        }
        return response()->json($client);
   }


   public function store(Request $request)
   {

       $data = Client::validateData($request);
       $client = new Client();
       $client->nom = $data['nom'];
       $client->prenom = $data['prenom'];
       $client->telephone = trim($data['telephone']);
       $client->address1 = $data['address1'];
       $client->address2 = $data['address2'];
       $client->email = $data['email'];
       $client->bincode = Hash::make($data['bincode']);
       $client->coordinates = $data['coordinates'];
       if ($data['type_client_id']) {
          $client->type_client_id = $data['type_client_id'];
       }else{
          $client->type_client_id = null;
       }
       if ($client->save()) {
            return response()->json(['le client à été creer avec success' => $client]);
       }else{
             return response()->json(['error '=> 'Une erreur est survenue lors de l\'enregistrement']);
       }
   }


   public function show(Client $client)
   {
        $clients = Client::find($client->id);
        $clients->makeHidden(['created_at','updated_at','type_client_id']);
        $clients->type_client = $clients->type_client->makeHidden(['created_at','updated_at']);
        if ($clients) {
            return response()->json(['success'=> 'Le client exist', 'data' => $clients]);
        }
   }

   public function checkClient(Request $request){

        
        $telephone = $request->input('telephone'); 
        $bincode = $request->input('bincode');
        $client = Client::telephone($telephone);
        if($client->bincode){
            if (!$client || !Hash::check($bincode, $client->bincode)) {
                return response([
                    'error' => ["telephone incorrect ou Code bin est incorrect"]
                ],404);
            }
        }
        $client = $client->makeHidden(['created_at','updated_at','type_client_id']);
        if ($client->type_client_id != null) 
        {
            $client->type_client =  $client->type_client->makeHidden(['created_at','updated_at']);
        }   
        return response()->json(['success' => $client]);
   }



}