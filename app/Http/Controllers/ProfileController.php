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
            // Create the public/profile_photos directory if it doesn't exist
            $publicDir = public_path('profile_photos');
            if (!file_exists($publicDir)) {
                mkdir($publicDir, 0755, true);
            }

            // Generate a unique filename: replace special characters in user's name with underscores,
            // append current timestamp, and add the original file extension
            $filename = preg_replace('/[^A-Za-z0-9_.-]/', '_', $request->name) . '_' . time() . '.' . $request->file('photo')->getClientOriginalExtension();

            // Move the uploaded file to the public/profile_photos directory
            $request->file('photo')->move($publicDir, $filename);

            // Save the photo path as 'profile_photos/<filename>' (without 'public/' prefix)
            $user->photo = 'profile_photos/' . $filename;
        }

        // Save the updated user data
        $user->save();

        // Redirect back with a success message
        return back()->with('success', 'Profile updated successfully!');
    }
}
