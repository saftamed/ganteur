<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Produit extends Model
{
    protected $fillable = ['img','name','ref','prix','prixG','four','qte'];
    public function roles()
    {
        return $this->belongsToMany('App\Commande');
    }
     public function provar()
    {
        return $this->hasMany('App\Provar');
    }
}
