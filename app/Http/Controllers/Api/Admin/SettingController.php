<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Setting::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();

        foreach($data as $key => $value)
        {
            if($request->hasFile($key))
            {
                $path = settings()->get($key);

                if($path != null && Storage::disk('public')->exists($path))
                {
                    Storage::disk('public')->delete($path);
                }

                $originalFilename = $value->getClientOriginalName();

                $value = $value->storeAs('settings', $originalFilename, 'public');
            }
            settings()->set($key, $value);
        }

        return [
            'message' => 'Settings updated successfully'
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
