<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function login() {
        return view('login');
    }

    public function authenticate(Request $request) {
        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            return redirect('/dashboard')->with(['success_title' => 'Success', 'success_info' => 'Logged in successfully']);
        } else {
            return back()->withErrors(['error' => 'Invalid credentials. Please try again.'])->withInput($request->only('username'));
        }
    }
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with(['success_title' => 'Success', 'success_info' => 'Logged out successfully']);
    }
}
