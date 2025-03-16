<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfilePictureController extends Controller
{
    public function upload(Request $request, $userid)
    {
        $request->validate([
            'profile_picture' => 'required|image|mimes:jpeg,png,jgp,gif|max:2048'
        ]);

        $user = User::findOrFail($userId);

        $path = $request->file('profile_picture')->store('profile_picture', 'public');

        $user->profile_picture = $path;
        $user->save();

        return response()->json([
            'message' => 'Profile picture uploaded successfully',
            'profile_picture_url' => asset("storage/{$path}")
        ]);
    }

    public function show($userId)
    {
        $user = User::findOrFail($userId);

        if ($user->profile_picture) {
            return response()->json([
                'profile_picture_url' => asset("storage/{$user->profile_picture}")
            ]);

            return response()->json([
                'message' => 'No profile picture found'
            ], 404);
        }
    }
}
