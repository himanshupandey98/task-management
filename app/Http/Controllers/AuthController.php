<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        try {
            $credentials = $request->validate([
                'email' => 'required|email',
                'password' => 'required|min:6',
            ]);

            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();
                return redirect()->route('tasks'); // Redirect to tasks page after login
            }

            return back()->withErrors([
                'email' => 'Invalid email or password',
            ]);
        } catch (\Exception $e) {
            return back()->withErrors([
                'error' => 'Something went wrong. Please try again.',
            ]);
        }
    }

    public function logout(Request $request)
    {
        try {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect('/login'); // Redirect to login page after logout
        } catch (\Exception $e) {
            return back()->withErrors([
                'error' => 'Failed to logout. Please try again.',
            ]);
        }
    }
}
