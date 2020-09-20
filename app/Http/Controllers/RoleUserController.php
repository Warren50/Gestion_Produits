<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Role;
use App\User;
class RoleUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getRoleByUser()
    {
        $role = Role::find(2);
        if($role==null){
            $notFound = new APIError;
            $notFound->setStatus("404");
            $notFound->setCode("ROLE_NOT_FOUND");
            $notFound->setMessage("Role id not found");

            return response()->json($notFound, 404);
        }
        
        $user = User::find(4);
        if($user==null){
            $notFound = new APIError;
            $notFound->setStatus("404");
            $notFound->setCode("USER_NOT_FOUND");
            $notFound->setMessage("USER id not found in database.");

            return response()->json($notFound, 404);
        }
        $user->attachRole($role); 

        return response()->json($user->permissions);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function assignRole()
    {
        //
    }

    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function FindByUserId($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
