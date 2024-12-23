<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index() {
        return view('profile', [
            'title' => 'Profile',
        ]);
    }

    public function update(Request $request, User $user) {
        // dd($request);

        $validateData = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:15|unique:users,username,' . $user->id,
            'phone' => 'nullable|numeric|digits_between:10,15',
            'address' => 'nullable|string|max:255',
        ]);

        if ($request->file('image')) {
            if ($request->oldImage) {
                Storage::delete($request->oldImage);
            }
            $validateData['image'] = $request->file('image')->store('user-profile');
        }

        User::where('id', $user->id)->update($validateData);
        
        return redirect('/profile')->with('success', 'Profile updated successfully!');
    }

    public function contact()
    {
        return view('contact', [
            'title' => 'Contact'
        ]);
    }
}
