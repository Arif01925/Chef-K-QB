<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
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

        try {
            // Update the user's name and email
            $user->name = $request->name;
            $user->email = $request->email;

            // Handle photo upload if a photo is provided
            if ($request->hasFile('photo')) {
                // Before saving a new photo, check if the user already has a previous photo and delete it
                if ($user->photo && file_exists(public_path($user->photo))) {
                    unlink(public_path($user->photo));
                }

                // Generate filename based only on the user's name
                $ext = $request->file('photo')->getClientOriginalExtension();
                $filename = Str::slug($user->name) . '.' . $ext;

                // Upload destination: public/profile_photos
                $targetDir = public_path('profile_photos');

                if (!file_exists($targetDir)) {
                    mkdir($targetDir, 0755, true);
                }

                // Move the new uploaded file
                $request->file('photo')->move($targetDir, $filename);

                // Save the photo path as profile_photos/<filename> in the database
                $user->photo = 'profile_photos/' . $filename;
            }

            // Save the updated user data
            $user->save();

            // Redirect back with a success message
            return back()->with('success', 'Profile updated successfully!');
        } catch (\Exception $e) {
            // Redirect back with an error message
            return back()->with('error', 'Failed to update profile. Please try again.');
        }
    }
}
