<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Resources\AdminResource;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
class AdminsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return AdminResource::collection(User::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'email' => Rule::unique('users'),
        ]);

        $data['password'] = Hash::make('password');

        $user = User::create($data);

        $file = $request->file('image');

        $user->addMedia($file)->toMediaCollection('profiles');

        if($request->role_id)
        {
            $role = Role::findOrFail($request->role_id);
            $user->syncRoles([$role]);
        }

        return [
            'message' => 'Admin created successfully'
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
    public function update(Request $request, User $admin)
    {
        $data = $request->validate([
            'name' => 'required',
            'email' => Rule::unique('users')->ignore($admin->id),
        ]);

        if($request->hasFile('image'))
        {
            $admin->media()->delete();
        }

        if($request->password)
        {
            $data['password'] = Hash::make($request->password);
        }

        $file = $request->file('image');

        $admin->addMedia($file)->toMediaCollection('profiles');

        $admin->update($data);

        if($request->role_id)
        {
            $role = Role::findOrFail($request->role_id);
            $admin->syncRoles([$role]);
        }

        return [
            'message' => 'admin updated successfully'
        ];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $admin)
    {
        $admin->media()->delete();

        $admin->delete();

        return [
            'message' => 'admin deleted successfully'
        ];
    }
}
