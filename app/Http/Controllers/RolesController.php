<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
/*use Illuminate\Support\Facades\Validator;*/
use Illuminate\Support\Str;
use App\Role;
use App\Permission;
use App\APIError;
use App\User;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getRoles(Request $req)
    {
        $roles = Role::simplePaginate($req->has('limit') ? $req->limit: 15);
        return response()->json($roles);
    }

    public function getPermissions(){
        $permissions = Permission::get();
        return response()->json($permissions);
    }

    public function createRole(Request $request)
    {
        $role = new Role();
        $role->name = $request->name;
        $role->display_name = Str::slug($request->name) .'_' .time();
        $role->description = $request->description;
        $role->permissions()->sync($request->permissions);
        $role->save();
        
        return response()->json($role);
    }
    public function test(Request $request){
        $role = Role::find('create');
        $user = User::find(2);
        
        $ok = $user->roles()-attach($user);
        return response()->json($ok);
    }
    public function createPermissions(Request $request)
    {
        $permission = new Permission();
        $permission->name = $request->name;
        $permission->display_name = Str::slug($request->name) .'_' .time();
        $permission->description = $request->description;
        $permission->save();
        
        return response()->json($permission);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function findRole($id)
    {
        $role = Role::find($id);
        if($role==null){
            $notFound = new APIError;
            $notFound->setStatus("404");
            $notFound->setCode("ROLE_NOT_FOUND");
            $notFound->setMessage("Role id not found");

            return response()->json($notFound, 404);
        }
        $role->permissions;
        return response()->json($role);
    }

    public function findPermission($id)
    {
        $permission = Permission::find($id);
        if($permission==null){
            $notFound = new APIError;
            $notFound->setStatus("404");
            $notFound->setCode("PERMISSION_NOT_FOUND");
            $notFound->setMessage("permission id not found");

            return response()->json($notFound, 404);
        }
        return response()->json($permission);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateRole(Request $request, $id)
    {
        $role = Role::find($id);
        if($role==null){
            $notFound = new APIError;
            $notFound->setStatus("404");
            $notFound->setCode("ROLE_NOT_FOUND");
            $notFound->setMessage("Role id not found");

            return response()->json($notFound, 404);
        }
        $role->name = $request->name;
        $role->display_name = Str::slug($request->name) .'_' .time();
        $role->description = $request->description;
        $role->update();
        return response()->json($role);
    }

    public function updatePermission(Request $request, $id)
    {
        $permission = Permission::find($id);
        if($permission==null){
            $notFound = new APIError;
            $notFound->setStatus("404");
            $notFound->setCode("PERMISSION_NOT_FOUND");
            $notFound->setMessage("permission id not found");

            return response()->json($notFound, 404);
        }
        $permission->name = $request->name;
        $permission->display_name = Str::slug($request->name) .'_' .time();
        $permission->description = $request->description;
        $permission->update();
        return response()->json($permission);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyRole($id)
    {
        $role = Role::find($id);
        if($role==null){
            $notFound = new APIError;
            $notFound->setStatus("404");
            $notFound->setCode("ROLE_NOT_FOUND");
            $notFound->setMessage("Role id not found");

            return response()->json($notFound, 404);
        }
        $role->delete();
        return response()->json(null);
    }

    public function destroyPermission($id)
    {
        $permission =Permission ::find($id);
        if($permission==null){
            $notFound = new APIError;
            $notFound->setStatus("404");
            $notFound->setCode("PERMISSION_NOT_FOUND");
            $notFound->setMessage("Permission id not found");

            return response()->json($notFound, 404);
        }
        $permission->delete();
        return response()->json(null);
    }

    public function attachPermissionToRole($rid,$pid){
        $role = Role::find($rid);
        $permission = Permission::find($pid);

        $role->attachPermissions($permission);
        $role->save();
        return response()->json($role);

        
    }

    public function syncAbilities(Request $req, $id) {
        $user = User::find($id);
        abort_if($user == null, 404, "User not found !");
        $roles = json_decode($req->roles);
        $permissions = json_decode($req->permissions);
        abort_unless(is_array($roles) && is_array($permissions), 400, "Roles and permissions must be both json array of id");

        foreach ($roles as $roleId) {
            abort_if(Role::find($roleId) == null, 404, "Role of id $roleId not found !");
        }

        foreach ($permissions as $permissionId) {
            abort_if(Permission::find($permissionId) == null, 404, "Permission of id $permissionId not found !");
        }

        $user->syncPermissions([]);
        $user->syncRoles($roles);
        $user->syncPermissionsWithoutDetaching($permissions);

        $data = [
            'roles' => $user->roles,
            'permissions' => $user->allPermissions()
        ];

        return response()->json($data);
    }
}
