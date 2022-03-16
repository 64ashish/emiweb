<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\RoleRequest;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleContorller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
//        return "this should return roles";
        $roles = Role::whereNotIn('name', ['admin'])->get();
        return view('admin.roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.roles.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoleRequest $roleRequest, Role $role)
    {
        $role->create($roleRequest->all());

        return redirect('/admin/roles')->with('success', 'Role created!');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        //
        $permissions = Permission::all();
        return view('admin.roles.edit', compact('role', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RoleRequest $roleRequest, Role $role)
    {
        //
        $role->update($roleRequest->all());

        return redirect('/admin/roles')->with('success', 'Role created!');
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

    /**
     * @param Request $request
     * @param Role $role
     * @return void
     */
    public function updatePermission(Request $request, Role $role)
    {
//        first check if role has permission or not
        if($role->hasPermissionTo($request->permission))
        {
            return redirect('/admin/roles')->with('success', 'Role already has this permission');
        }
            $role->givePermissionTo($request->permission);
            return redirect('/admin/roles')->with('success', 'Permission added to role');

    }

    public function revokePermission(Role $role, Permission $permission )
    {
        if($role->hasPermissionTo($permission->name));
        {
            $role->revokePermissionTo($permission->name);
            return redirect('/admin/roles')->with('success', 'Permission revoked');
        }

        return redirect('/admin/roles')->with('success', 'Role and Permission didnt existed');
    }
}
