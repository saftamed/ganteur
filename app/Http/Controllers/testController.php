<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Commande;
use App\Produit;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class testController extends Controller
{
  public function index2()
    {
      $result= DB::table('commande_produit')->selectRaw('produit_id,sum(qte) c')
      ->where('created_at','>=',date("Y-n").'-01')
      ->orderBy('c','DESC')
      ->groupBy('produit_id')
      ->take(5) ->get();
          foreach ($result as $key => $v) {
            $pp = Produit::find($v->produit_id);
            if($pp == null)
            continue;
            $result[$key]->produit_id = $pp['name'];
          }
          return $result;
          $c =  Commande::with('client','produits')->paginate(1);
           return response()->json($c);
        }
        public function index()
        {

          
          
      $result = Commande::selectRaw('year(created_at) year,monthname(created_at) month, sum(prixT) data,count(*) c')
      ->where('created_at','>',date("Y").'-01-01')
      ->groupBy('year','month')
       ->get('month','data');
 
      return $result;

      $p= Produit::with('provar')->roles()->get();
      $pp= $p-> groupBy('color');

      return $pp;
      


       /*Commande::create([
        "ref" =>'ref-555',
        "client_id" =>'1',
        "prixT" =>'1000',
        "qte" =>'4',
        "etat" =>'en cours',
       ]);

     /*$c = new Commande;
       $c->ref = 'ref-505';
       $c->client_id = '1';
       $c->prixT = '1000';
       $c->etat = 'en cours';

       $c->save();

       $c->produits()->attach([
           1 =>[
             'qte' => '4',
             'prixT' => '200'
           ],
           2 =>[
            'qte' => '4',
            'prixT' => '10'
          ],
          3 =>[
            'qte' => '4',
            'prixT' => '1000'
          ],
       ]);

       */




    }
    public function index3(Request $request)
    {
       return $request->file('file')->store('');
    }
    public function index5($q)
    {
      return Storage::get($q);
    }
}
