<?php

namespace App\Http\Controllers;

use App\Commande;
use App\Client;
use App\Produit;
use Illuminate\Http\Request;

class CommandeController extends Controller
{
    public function getProductByClient($id){
        
        $produits = Commande::select('produits.libelle','produits.prix_u','commandes.quantite')
                    ->join('produits',['produits.id' => 'commandes.produit_id'])
                    ->join('clients',['clients.id' => 'commandes.client_id'])
                    ->where('clients.id','=', $id)->get();
        
        return response()->json($produits);
    }

    public function getClientBuy(){
        
        $clients = Commande::select('clients.name')
                    ->join('produits',['produits.id' => 'commandes.produit_id'])
                    ->join('clients',['clients.id' => 'commandes.client_id'])
                    ->where('commandes.quantite','>=',2)->get();

        return response()->json($clients);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Commande  $commande
     * @return \Illuminate\Http\Response
     */
    public function show(Commande $commande)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Commande  $commande
     * @return \Illuminate\Http\Response
     */
    public function edit(Commande $commande)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Commande  $commande
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Commande $commande)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Commande  $commande
     * @return \Illuminate\Http\Response
     */
    public function destroy(Commande $commande)
    {
        //
    }
}
