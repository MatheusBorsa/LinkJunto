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
        try {
            $request->validate([
                'bio' => 'nullable|string',
                'profile_picture' => 'nullable|url'
            ]);

            $user = Auth::user();
            $user->update($request->only(['bio', 'profile_picture']));

            return response()->json($user);

        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation Error',
                'errors' => $e->errors()
            ], 422);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occured while updating the user profile.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function addLink(Request $request)
    {
        try {
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

        } catch (ValidationException $e) {
            return response()->json([
                'messsage' => 'Validation Error',
                'errors' => $e->errors()
            ], 422);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occured while adding the link.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function updateLinkOrder(Request $request, $id)
    {
        try {
            $request->validate([
                'order' => 'required|integer'
            ]);

            $link = Link::where('user_id', Auth::id())->findOrFail($id);
            $link->update(['order' => $request->input('order')]);

            return response()->json($link);

        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Link not found.'
            ], 404);

        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation error',
                'erros' => $e->errors()
            ], 422);

        } catch (\Exception $e) {
            return respone()->json([
                'message' => 'An error occured while updating the link order.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function deleteLink($id)
    {
        try {
            $link = Link::where('user_id', Auth::id())->findOrFail($id);
            $link->delete();

            return response()->json(['message' => 'Link deleted succesfully']);

        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Link not found',
                'error' => $e->getMessage()
            ], 404);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occured while deleting the link',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show()
    {
        try {
            $user = Auth::user()->load(['links' => function ($query) {
                $query->orderBy('order');
            }]);

            return response()->json($user);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occured while fetching the user profile.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function publicProfile($username)
    {
        try {
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

        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'User not found.'
            ], 404);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occured while fetching the public profile.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function upload(Request $request, $userId)
    {
        $request->validate([
            'profile_picture' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = User::findOrFail($userId);

        if ($request->hasFile('profile_picture')) {
            if ($user->profile_picture) {
                Storage::disk('public')->delete($user->profile_picture);
            }

            $path = $request->file('profile_picture')->store('profile_pictures', 'public');

            $user->profile_picture = $path;
            $user->save();

            return response()->json([
                'message' => 'Profile picture uploaded successfully',
                'profile_picture_url' => asset("storage/{$path}"),
            ]);
        }
    }

    public function showPicture($userId)
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
