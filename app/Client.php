<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Client extends Model
{

    protected $fillable =
    [
        'nom','prenom','telephone','address1','address2','email','coordinates','type_client_id','bincode'
    ];


    public function type_client()
    {
        return $this->belongsTo(TypeClient::class,"type_client_id");
    }


       public function scopeTelephone($query,$telephone)
        {
            return $query->whereTelephone($telephone)->first();
        }

        public function scopeCode($query, $bincode)
        {
            return $query->where('bincode', '=', $bincode);
        }


        
        public static function validateData(Request $request){
            $data = $request->validate([
                'nom' => 'required',
                'prenom' => 'required',
                'telephone' => 'required',
                'address1' => 'required',
                'address2' => 'required',
                'email' => 'required',
                'coordinates' => 'required',
                'type_client_id' => '',
                'bincode' => 'required',
            ]);

            return $data;
        }
}