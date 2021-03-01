<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
  protected $fillable = ['name','tel','adresse','ville','email'];
     public function commandes()
       {
           return $this->hasMany('App\Commande', 'client_id', 'id');
       }
    
}
