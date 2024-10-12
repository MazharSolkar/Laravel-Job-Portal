<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index() {
        $users = User::latest()->paginate(10);
        return view('admin.users.list', compact('users'));
    }

    public function edit($id) {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    public function update($id, Request $request) {

        $user = User::findOrFail($id);

        $validateData = $request->validate([
            'name' => 'required|min:5|max:20',
            'email' => 'required|email|unique:users,email,'.$user->id.'id',
            'mobile' => 'nullable|numeric',
            'designation' => 'nullable|string|max:50'
        ]);

        $user->update($validateData);

        return redirect()->route('admin.users')->with('success', 'User Information updated successfully.');
    }
}
