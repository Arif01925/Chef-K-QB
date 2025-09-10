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
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'photo' => 'nullable|image|max:2048',
        ]);
        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->hasFile('photo')) {
            $filename = preg_replace('/[^A-Za-z0-9_.-]/', '_', $request->name) . '.' . $request->file('photo')->getClientOriginalExtension();
            $path = $request->file('photo')->storeAs('profile_photos', $filename, 'public');
            $user->photo = 'profile_photos/' . $filename;
        }
        $user->save();
        return back()->with('success', 'Profile updated successfully!');
    }
}
