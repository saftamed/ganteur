<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Client;
class ClientController extends Controller
{
    public $i = 4 ;
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    public function get()
    {
        return $this->getClients();
    }
    public  function delate($id)
    {
        $p = Client::find($id);
        if(!empty($p)){
            $p->delete();
            return $this->getClients();
        }
        return 'f';
    }
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string',
            'tel' => 'required|string',
            'id' => 'integer',
            'adresse' => 'required|string',
            'ville' => 'required|string',   
        ]);
        
        if($data['id']>0){
            $p= Client::find($data['id']);
            $p->update($data);
            $p->save();
        }else{
            $p =  Client::Create($data);
            $p->save();
        }
        
        

        return $this->getClients();
        
    }

    public function search($q)
    {
        if(!empty($q)){
            $pp['data'] = Client::where('name','LIKE', '%' . $q . '%')->take(5)->get();
            return response()->json($pp);
        }
        return 'f';
    }
    public function getClients()
    {
        return response()->json(Client::orderBy('created_at','DESC')->Paginate($this->i));
    }
    public function getAllClients()
    {
        return response()->json(Client::all());
    }
}
