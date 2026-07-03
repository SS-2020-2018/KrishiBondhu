<?php

namespace App\Http\Controllers;

use App\Models\FarmerProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class FarmerProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();

        $profile = $user->farmerProfile;
        $profileImage = $user->profile_image ?: ($profile?->profile_image);

        return view('profile.farmer', compact('user', 'profile', 'profileImage'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
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

        $profile = $user->farmerProfile ?: FarmerProfile::firstOrNew(['user_id' => $user->id]);

        $profileData = [
            'farm_location' => $request->farm_location,
            'crop_type' => $request->crop_type,
            'land_size' => $request->land_size,
            'contact_details' => $request->contact_details,
            'farming_history' => $request->farming_history,
        ];

        if ($request->hasFile('profile_image')) {
            $previousImages = array_filter([
                $user->profile_image,
                $profile->profile_image,
            ]);

            foreach ($previousImages as $previousImage) {
                if (Storage::disk('public')->exists($previousImage)) {
                    Storage::disk('public')->delete($previousImage);
                }
            }

            $fileName = 'user_' . $user->id . '_' . time() . '.' . $request->file('profile_image')->getClientOriginalExtension();
            $path = $request->file('profile_image')->storeAs('profile', $fileName, 'public');

            $profileData['profile_image'] = $path;
        }

        $profile->fill($profileData);
        $profile->save();

        return redirect()->route('dashboard')->with('success', 'Profile updated successfully!');
    }
}