<?php

namespace App\Http\Controllers;

use App\Client;
use Illuminate\Http\Request;
use App\APIError;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
        $clients = Client::simplePaginate($req->has('limit') ? $req->limit : 15);
        return response()->json($clients);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $client = new Client();
        $client->name = $request->name;
        $client->email = $request->email;
        //upload image
        $client->avatar ="";
        if(isset($request->avatar)){
            $avatar = $request->file('avatar'); 
            if($avatar != null){
                $extension = $avatar->getClientOriginalExtension();
                $relativeDestination = "uploads/files";
                $destinationPath = public_path($relativeDestination);
                $safeName = "avatar".time().'.'.$extension;
                $avatar->move($destinationPath, $safeName);
                $path1 = "$relativeDestination/$safeName";
                $client->avatar =$path1;

            }
        }
        $client->save();
        return response()->json($client);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $client = Client::find($id);
        if($client==null){
            $notFound = new APIError;
            $notFound->setStatus("404");
            $notFound->setCode("CLIENT_NOT_FOUND");
            $notFound->setMessage("Ce CLIENT n'existe pas!");

            return response()->json($notFound, 404);
        }
        return response()->json($client);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $client = Client::find($id);
        if($client==null){
            $notFound = new APIError;
            $notFound->setStatus("404");
            $notFound->setCode("CLIENT_NOT_FOUND");
            $notFound->setMessage("Ce CLIENT n'existe pas!");

            return response()->json($notFound, 404);
        }
        $path1 = "";
        //upload image
        if(isset($request->avatar)){
            $avatar = $request->file('avatar'); 
            if($avatar != null){
                $extension = $avatar->getClientOriginalExtension();
                $relativeDestination = "uploads/Files";
                $destinationPath = public_path($relativeDestination);
                $safeName = "avatar".time().'.'.$extension;
                $avatar->move($destinationPath, $safeName);
                $path1 = "$relativeDestination/$safeName";
            }
        }
        $client->name = $request->name;
        $client->email = $request->email;
        $client->avatar= $path1;
        $client->update();
        return response()->json($client);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $client = Client::find($id);
        if($client==null){
            $notFound = new APIError;
            $notFound->setStatus("404");
            $notFound->setCode("CLIENT_NOT_FOUND");
            $notFound->setMessage("Ce CLIENT n'existe pas!");

            return response()->json($notFound, 404);
        }
        $client->delete();
        return response()->json(null);
    }
}
