<?php

namespace App\Http\Controllers\Api\Tenant\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Resources\UserResource;
use Illuminate\Validation\Rule;
class ProfileController extends Controller
{
    public function index(User $user)
    {
        return new UserResource($user);
    }

    public function updateProfile(Request $request, User $user)
    {
        $data = $request->validate([
            'name' => 'required',
            'email' => Rule::unique('users')->ignore($user->id),
        ]);

        if($request->hasFile('image'))
        {
            $user->media()->delete();
            $file = $request->file('image');
            $user->addMedia($file)->toMediaCollection('profiles');
        }

        $user->update($data);

        return [
            'message' => 'profile updated successfully'
        ];
    }
}
