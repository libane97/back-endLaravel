<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name','description','price','reduction','stock','disponibilite','image','category_id'];
    public function categories(){
        return $this->belongsTo(Category::class,"category_id");
   }


   public function setFirstNameAttribute($value)
   {
       $this->attributes['name'] = strtoupper($value);
   }
}