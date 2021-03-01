<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
/*  Authorization   Bearer + */
Route::post('/login','AuthController@login');

Route::get('/produits','ProduitController@get');
Route::get('/produits/all','ProduitController@getAllproduits');
Route::get('/produits/delate/{id}','ProduitController@delate');
Route::post('/produits/add','ProduitController@store');
Route::get('/produits/search/{q}','ProduitController@search');

Route::get('/clients','ClientController@get');
Route::get('/clients/all','ClientController@getAllClients');
Route::get('/clients/delate/{id}','ClientController@delate');
Route::post('/clients/add','ClientController@store');
Route::get('/clients/search/{q}','ClientController@search');

Route::get('/commandes/{qc?}','CommandeController@get');
Route::get('/commandes/delate/{id}/{etat}','CommandeController@delate');
Route::post('/commandes/add','CommandeController@store');
Route::get('/commandes/search/{q}/{qc}','CommandeController@search');

Route::get('/test', 'testController@index');
Route::get('/test2', 'testController@index2');
Route::post('/test3', 'testController@index3');