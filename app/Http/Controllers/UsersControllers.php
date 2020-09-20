<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\APIError;

class UsersControllers extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
        $users = User::simplePaginate($req->has('limit') ? $req->limit : 15);
        return response()->json($users);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $users = new User();
        $users->name = $request->name;
        $users->email = $request->email;
        $users->password = $request->password;
        //upload image
        $users->avatar ="";
        if(isset($request->avatar)){
            $avatar = $request->file('avatar'); 
            if($avatar != null){
                $extension = $avatar->getClientOriginalExtension();
                $relativeDestination = "uploads/files";
                $destinationPath = public_path($relativeDestination);
                $safeName = "avatar".time().'.'.$extension;
                $avatar->move($destinationPath, $safeName);
                $path1 = "$relativeDestination/$safeName";
                $users->avatar =$path1;

            }
        }
        $users->save();
        return response()->json($users);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        if($user==null){
            $notFound = new APIError;
            $notFound->setStatus("404");
            $notFound->setCode("USER_NOT_FOUND");
            $notFound->setMessage("USER id not found in database.");

            return response()->json($notFound, 404);
        }
       return response()->json($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);
        if (!$user) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("USER_NOT_FOUND");
            return response()->json($apiError, 404);
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
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->avatar= $path1;
        $user->update();
        return response()->json($user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        if(!$user){
            $notFound = new APIError;
            $notFound->setStatus("404");
            $notFound->setCode("USER_NOT_FOUND");
            $notFound->setMessage("User id not found in database.");

            return response()->json($notFound, 404);
        }

        $user->delete();

        return response()->json(null);
    }
}
