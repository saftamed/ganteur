<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Commande extends Model
{
    protected $fillable = ['ref','client_id','prixT','qte','etat'];
    public function client()
    {
        return $this->belongsTo('App\Client');
    }

    public function produits()
    {
        return $this->belongsToMany('App\Produit')
         ->withPivot('qte','prixT','color','size');
    }
    protected $casts = [
        'begin' => 'date:hh:mm'
    ];
}
