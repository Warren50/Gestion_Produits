<?php

namespace App\Http\Controllers;

use App\Produit;
use App\APIError;
use Illuminate\Http\Request;


class ProduitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
        $produits = Produit::simplePaginate($req->has('limit') ? $req->limit : 15);
        return response()->json($produits);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $produit = new Produit();
        $produit->libelle = $request->libelle;
        $produit->prix_u = $request->prix_u;

        $produit->save();
        return response()->json($produit);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Produit  $produit
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $produit = Produit::find($id);
        if($produit==null){
            $notFound = new APIError;
            $notFound->setStatus("404");
            $notFound->setCode("PRODUIT_NOT_FOUND");
            $notFound->setMessage("Ce PRODUIT n'existe pas!");

            return response()->json($notFound, 404);
        }
        return response()->json($produit);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Produit  $produit
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $produit = Produit::find($id);
        if($produit==null){
            $notFound = new APIError;
            $notFound->setStatus("404");
            $notFound->setCode("PRODUIT_NOT_FOUND");
            $notFound->setMessage("Ce PRODUIT n'existe pas!");

            return response()->json($notFound, 404);
        }
        $produit->libelle = $request->libelle;
        $produit->prix_u = $request->prix_u;
        $produit->update();

        return response()->json($produit);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Produit  $produit
     * @return \Illuminate\Http\Response
     */
    public function destroy(Produit $produit)
    {
        $produit = Produit::find($id);
        if($produit==null){
            $notFound = new APIError;
            $notFound->setStatus("404");
            $notFound->setCode("PRODUIT_NOT_FOUND");
            $notFound->setMessage("Ce PRODUIT n'existe pas!");

            return response()->json($notFound, 404);
        }
        $produit->delete();
        return response()->json(null);
    }
}
