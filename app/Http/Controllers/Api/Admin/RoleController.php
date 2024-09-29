<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Validation\Rule;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Role::with('permissions')->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => Rule::unique('roles'),
        ]);

        $role = Role::create($data);

        if($request->permissions)
        {
            $permissions = Permission::whereIn('id', json_decode($request->permissions))->get();
            $role->syncPermissions($permissions);
        }

        return [
            'message' => 'Role created successfully'
        ];
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        $data = $request->validate([
            'name' => Rule::unique('roles')->ignore($role->id),
        ]);

        $role->update($data);

        if($request->permissions)
        {
            $permissions = Permission::whereIn('id', json_decode($request->permissions))->get();
            $role->syncPermissions($permissions);
        }

        return [
            'message' => 'role updated successfully'
        ];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        $role->delete();

        return [
            'message' => 'role deleted successfully'
        ];
    }
}
