<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AccountController extends Controller
{
    // This method will show user registration page
    public function registration() {
        return view('registration');
    }

    // This method will save a user
    public function processRegistration(Request $request) {
        $validateData = $request->validate([
            'name' => 'required:min:5|max:20',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:5|same:password_confirmation',
            'password_confirmation' => 'required'
        ]);

        // Hashing the password before storing in db
        $validateData['password'] = bcrypt($request->password);

        // Remove password_confirmation from the data array since we don't need to store it
        unset($validateData['password_confirmation']);

        // Create the user
        $user = User::create($validateData);

        if($user) {
            return redirect()->route('account.login')
                             ->with('success', 'Registrated Successfully.');
        }
    }
    // This method will show user login page
    public function login() {
        return view('login');
    }

    public function processLogin(Request $request) {
        $validateData = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if(Auth::attempt($validateData)) {
            return redirect()->route('account.profile');
        } else {
            return redirect()->route('account.login')->with('error', 'Invalid Credentials.');
        }
    }

    public function profile() {

        // getting the logged-in user.
        $user = Auth::user();

        return view("profile", ['user'=> $user]);
    }

    public function updateProfile(Request $request) {

        // Getting the logged-in user.
        $user = Auth::user();

        $validateData = $request->validate([
            'name' => 'required|min:5|max:20',
            'email' => 'required|email|unique:users,email,'.$user->id.'id',
            'mobile' => 'nullable|numeric',
            'designation' => 'nullable|string|max:50'
        ]);

        // $user->name = $request->name;
        // $user->email = $request->email;
        // $user->mobile = $request->mobile;
        // $user->designation = $request->designation;
        // $user->save();

        $user->update($validateData);

        return redirect()->route('account.profile')->with('success', 'Profile updated successfully.');
    }

    public function logout() {
        Auth::logout();
        return redirect()->route('account.login');
    }
}
