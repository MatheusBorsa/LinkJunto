<?php

namespace App\Http\Controllers;
use App\Models\Link;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController
{
    public function updateUser(Request $request)
    {
        $request->validate([
            'bio' => 'nullable|string',
            'profile_picture' => 'nullable|url'
        ]);

        $user = Auth::user();
        $user->update($request->only(['bio', 'profile_picture']));

        return response()->json($user);
    }

    public function addLink(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'url' => 'required|url',
            'order' => 'required|integer'
        ]);

        $user = Auth::user();

        $order = $request->input('order', $user->links()->max('order') + 1);

        $link = $user->links()->create([
            'title' => $request->input('title'),
            'url' => $request->input('url'),
            'order' => $order
        ]);

        return response()->json($link, 201); 
    }

    public function updateLinkOrder(Request $request, $id)
    {
        $request->validate([
            'order' => 'required|integer'
        ]);

        $link = Link::where('user_id', Auth::id())->findOrFail($id);
        $link->update(['order' => $request->input('order')]);

        return response()->json($link);
    }

    public function deleteLink($id)
    {
        $link = Link::where('user_id', Auth::id())->findOrFail($id);
        $link->delete();

        return response()->json(['message' => 'Link deleted succesfully']);
    }

    public function show()
    {
        $user = Auth::user()->load(['links' => function ($query) {
            $query->orderBy('order');
        }]);

        return response()->json($user);
    }

    public function publicProfile($username)
    {
        $user = User::where('username', $username)->first();

        if(!$user) {
            return response()->json(['messsage' => 'User not found'], 404);
        }

        $links = $user->links()->orderBy('order')->get();

        return response()->json([
            'user' => [
                'username' => $user->username,
                'bio' => $user->bio,
                'profile_picture' => $user->profile_picture
            ],
            'links' => $links,
        ]);
    }
}
