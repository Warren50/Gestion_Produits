<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Team;
use App\APIError;
class TeamsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
        $teams = Team::simplePaginate($req->has('limit') ? $req->limit : 15);
        return response()->json($teams);
    }
    public function store(Request $request)
    {
        $team = new Team();
        $team->name = $request->name;
        $team->display_name = Str::slug($request->name) .'_' .time();
        $team->description = $request->description;
        $team->save();
        
        return response()->json($team);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $team = Team::find($id);
        if($team==null){
            $notFound = new APIError;
            $notFound->setStatus("404");
            $notFound->setCode("TEAM_NOT_FOUND");
            $notFound->setMessage("Team id not found");

            return response()->json($notFound, 404);
        }
        return response()->json($team);
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
        $team = Team::find($id);
        if($team==null){
            $notFound = new APIError;
            $notFound->setStatus("404");
            $notFound->setCode("TEAM_NOT_FOUND");
            $notFound->setMessage("Team2 id not found");

            return response()->json($notFound, 404);
        }
        $team->name = $request->name;
        $team->display_name = Str::slug($request->name) .'_' .time();
        $team->description = $request->description;
        $team->update();
        return response()->json($team);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $team = Team::find($id);
        if($team==null){
            $notFound = new APIError;
            $notFound->setStatus("404");
            $notFound->setCode("TEAM_NOT_FOUND");
            $notFound->setMessage("Team3 id not found");
            return response()->json($notFound, 404);
        }
        $team->delete();
        return response()->json(null);
    }
}
