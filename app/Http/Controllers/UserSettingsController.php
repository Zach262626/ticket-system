<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfileRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserSettingsController extends Controller
{
    public function index()
    {
        return view('settings.user');
    }

    public function updateProfile(UpdateProfileRequest $request)
    {
        $user = Auth::user();
        $validated = $request->validated();

        $user->name = $validated['name'];

        if (!empty($validated['email'])) {
            $user->email = $validated['email'];
        }

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return back()->with('success', 'Profile updated successfully.');
    }
    public function updateProfilePicture(Request $request)
    {
        $request->validate([
            'profile_picture' => ['required', 'image', 'max:2048'],
        ]);

        $user = Auth::user();

        // Delete old picture if it exists
        if ($user->profile_picture && Storage::disk('public')->exists($user->profile_picture)) {
            Storage::disk('public')->delete($user->profile_picture);
        }

        // Store in central "public" disk, not tenant storage
        $path = $request->file('profile_picture')->store('profile_pictures/' . tenant()->id, 'public');

        $user->profile_picture = $path;
        $user->save();

        return back()->with('success', 'Profile picture updated successfully.');
    }
}
