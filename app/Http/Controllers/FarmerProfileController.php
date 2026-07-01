<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class FarmerProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        
        if ($user->role !== 'farmer') {
            return redirect()->route('home')->with('error', 'Unauthorized profile access.');
        }

        $profile = $user->farmerProfile;
        return view('profile.farmer', compact('user', 'profile'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        
        if ($user->role !== 'farmer') {
            return redirect()->route('home')->with('error', 'Unauthorized operation.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // 2MB Max Image Validation
            'farm_location' => 'nullable|string|max:255',
            'crop_type' => 'nullable|string|max:255',
            'land_size' => 'nullable|numeric|min:0',
            'contact_details' => 'nullable|string',
            'farming_history' => 'nullable|string',
        ]);

        $user->update([
            'name' => $request->name,
            'phone' => $request->phone,
        ]);

        $profileData = [
            'farm_location' => $request->farm_location,
            'crop_type' => $request->crop_type,
            'land_size' => $request->land_size,
            'contact_details' => $request->contact_details,
            'farming_history' => $request->farming_history,
        ];

        if ($request->hasFile('profile_image')) {
            if ($user->farmerProfile->profile_image && Storage::disk('public')->exists($user->farmerProfile->profile_image)) {
                Storage::disk('public')->delete($user->farmerProfile->profile_image);
            }

            $path = $request->file('profile_image')->store('profiles', 'public');
            $profileData['profile_image'] = $path;
        }

        $user->farmerProfile->update($profileData);

        return redirect()->route('profile.farmer')->with('success', 'Farmer Profile and Image updated successfully!');
    }
}