<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class ProfileController extends Controller
{
    public function show()
    {
        return view('profile', ['user' => Auth::user()]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        // Validate the input fields: name, email, and photo (optional, max 2048 KB)
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'photo' => 'nullable|image|max:2048',
        ]);

        // Update the user's name and email
        $user->name = $request->name;
        $user->email = $request->email;

        // Handle photo upload if a photo is provided
        if ($request->hasFile('photo')) {
            // Build a safe filename: name + timestamp + original extension
            $ext = $request->file('photo')->getClientOriginalExtension();
            $safeBase = preg_replace('/[^A-Za-z0-9\-_]/', '_', ($request->name ?: 'user'));
            $filename = $safeBase . '_' . time() . '.' . $ext;

            // Decide target dir: local → public/, live (non-local) → project root
            $targetDir = app()->environment('local')
                ? public_path('profile_photos')
                : base_path('profile_photos');

            if (!file_exists($targetDir)) {
                mkdir($targetDir, 0755, true);
            }

            // Move the file
            $request->file('photo')->move($targetDir, $filename);

            // Save path relative to the web root (works in both setups)
            $user->photo = 'profile_photos/' . $filename;
        }

        // Save the updated user data
        $user->save();

        // Redirect back with a success message
        return back()->with('success', 'Profile updated successfully!');
    }
}
