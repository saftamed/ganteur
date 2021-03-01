<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Commande;
use App\Produit;
use App\Provar;

use Illuminate\Support\Facades\Auth;
class CommandeController extends Controller
{
    public $i = 4 ;
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    public function get($qc)
    {
        if($qc == "all" || empty($qc)){
            return $this->getcommandes();
        }else{
            $cc =  Commande::where('etat','=',$qc)->orderBy('created_at','DESC')->with('client','produits')->paginate($this->i); 
            return response()->json($cc);
        }
    }
    public  function delate($id,$etat)
    {
        if($etat != "valider"){
            $p = commande::find($id);
            if(!empty($p)){
                foreach ($p->produits as $key => $pro) {
                    $pro->qte +=$pro->pivot->qte;
                    $pro->update();
                }
                $p->produits()->detach();
                $p->delete();

                return $this->getcommandes();
            }
            return 'f';
        }else{
            $p = commande::find($id);
            if(!empty($p)){
                $p->produits()->detach();
                $p->delete();
                return $this->getcommandes();
            }
            return 'f';
        }
    }
    public function store(Request $request)
    {

        if($request->id <= 0){
            $c = new Commande;
            $c->ref = $request->ref;
            $c->client_id = $request->client_id;
            $c->etat = $request->etat;
            $c->gro = $request->gro;
            $c->user = Auth::user()->name;
            $prixt =0;
            $att = array();
             foreach ($request->produits as $key => $p) {
                if($p == null)
                break;
                if($p['id'] > 0){
                 $pro = Produit::with("provar")->where('id',$p['id'])->get()[0];
                 $id=-1;
                 foreach ($pro['provar'] as $key => $va) {
                    if($va['color'] == $p['color'] && $va['size'] == $p['size']){
                        $id =  $key;
                    break;
                    }
                 }

                if($pro['provar'][$id]->qte  < $p['qte'])
                    return 'f';
                 $pri =   $p['qte'] * ($request->gro?$pro->prixG:$pro->prix);
                 $prixt +=  $pri;
                 $pv = Provar::find($pro['provar'][$id]->id);
                 $pv->qte -= $p['qte'];
                 $pv->save();
                 $att += [ $p['id'] => ['qte' => $p['qte'],'prixT'=>$pri,'color'=>$p['color'] ,'size' =>$p['size']]];
                }else{
                  break;
                }
             }
             $c->prixT = $prixt;
             $c->save();
            $c->produits()->attach($att);
     
        }else{
            $c = Commande::find($request->id);
            $c->ref = $request->ref;
            $c->client_id = $request->client_id;
            $c->etat = $request->etat;
            $c->gro = $request->gro;
            $prixt =0;
            $att = array();
                foreach ($request->lPorduit as $key => $p) {
                    if($p == null)
                     break;
                    if($p['id'] > 0){
                        $pro = Produit::with("provar")->where('id',$p['id'])->get()[0];
                        $id=-1;
                            foreach ($pro['provar'] as $key => $va) {
                               
                                    if($va['color'] == $p['color'] && $va['size'] == $p['size']){
                                    $id =  $key;
                                    break;
                                    }
                                }   
                            $pv = Provar::find($pro['provar'][$id]->id);
                            $pv->qte += $p['qte'];
                            $pv->save();
                       }else{
                         break;
                       }
                }

            $c->produits()->detach();
            foreach ($request->produits as $key => $p) {
                if($p == null)
                break;
                if($p['id'] > 0){
                    $pro = Produit::with("provar")->where('id',$p['id'])->get()[0];
                    $id=-1;
                    foreach ($pro['provar'] as $key => $va) {
                        if($va['color'] == $p['color'] && $va['size'] == $p['size']){
                            $id =  $key;
                        break;
                        }
                    }
                    if($pro['provar'][$id]->qte  < $p['qte'])
                        return 'f';
                    $pri =   $p['qte'] * ($request->gro?$pro->prixG:$pro->prix);
                    $prixt +=  $pri;
                    $c->produits()->attach([ $p['id'] => ['qte' => $p['qte'],'prixT'=>$pri,'color'=>$p['color'] ,'size' =>$p['size']]]);
                    $pv = Provar::find($pro['provar'][$id]->id);
                    $pv->qte -= $p['qte'];
                    $pv->save();
                }else{
                  break;
                }
             }
                 $c->prixT = $prixt;
                 $c->update();
        }   
        return $this->getcommandes();
        
    }

    

    public function search($q,$qc)
    {
        if($qc == "all" || empty($qc)){
            if(!empty($q)){
                $pp['data'] = commande::where('ref','LIKE', '%' . $q . '%')->orderBy('created_at','DESC')->with('client','produits')->take(5)->get();
                return response()->json($pp);
            }
            return 'f';
        }else{
            $cc =  Commande::where('ref','LIKE', '%' . $q . '%')->where('etat','=',$qc)->orderBy('created_at','DESC')->with('client','produits')->paginate($this->i); 
            return response()->json($cc);
        }

        
    }
    public function getcommandes()
    {
        $c =  Commande::orderBy('created_at','DESC')->with('client','produits')->paginate($this->i);
        return response()->json($c);
    }
    public function check($produits)
    {
        foreach ($produits as $key => $pp) {
           if($pp['id'] != $pp['idL']){
               return false;
           }
           return true;
        }
    }
}
