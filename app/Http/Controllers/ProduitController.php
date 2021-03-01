<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Produit;
use App\Client;
use App\Provar;
use Illuminate\Support\Facades\Storage;
class ProduitController extends Controller
{
    public $i = 2 ;
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    public function get()
    {
        return $this->getProduits();
    }
    public  function delate($id)
    {
        $p = Produit::find($id);
        if(!empty($p)){
            $p->delete();
            Storage::delete($p->img);
            return $this->getProduits();
        }
        return 'f';
    }
    public function store(Request $request)
    {      

      



        $data = $request->validate([
            'name' => 'required|string',
            'four' => 'required|string',
            'ref' => 'required|string',
            'id' => 'integer',
            'prix' => 'required|numeric',
            'prixG' => 'required|numeric',
            
        ]);

        if(!empty($request->file('file'))){
            $ImagName = $request->file('file')->store('');
            $data["img"] = $ImagName;
        }
        if($request->id <= 0){
            $p =  Produit::Create($data);
            $p->save();

              $dat =array(); 
        $size = ['l','m','xl','xxl','xxxl','xxxxl'];
                $j =json_decode($request->colors);
        foreach($j as $key => $color ){
           foreach($size as $s ){

                   $dat[]=['color'=>$color->color,
                       'size' => $s ,
                       'qte' => $color->$s,
                        'produit_id' => $p->id ];
               
           }
        }

        Provar::insert($dat);

        }else{
            $c = Produit::find($request->id);
            $c->provar()->delete();
            $c->update($data);
            $c->save();

                          $dat =array(); 
        $size = ['l','m','xl','xxl','xxxl','xxxxl'];
                $j =json_decode($request->colors);
        foreach($j as $key => $color ){
           foreach($size as $s ){

                   $dat[]=['color'=>$color->color,
                       'size' => $s ,
                       'qte' => $color->$s,
                        'produit_id' => $c->id ];
               
           }
        }
         Provar::insert($dat);
        }
       

        return $this->getProduits();
        
    }

    public function search($q)
    {
        if(!empty($q)){
            $pp['data'] = Produit::where('name','LIKE', '%' . $q . '%')->take(5)->get();
            return response()->json($pp);
        }
        return 'f';
    }
    public function getProduits()
    {
        return response()->json(Produit::with('provar')->orderBy('created_at','DESC')->Paginate($this->i));
    }
    public function getAllProduits()
    {
        return response()->json(["produits" =>Produit::with('provar')->get(),"clients" => Client::all()]);
    }
}
