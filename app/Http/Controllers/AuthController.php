<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\DoctorCertificate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Register a new user.
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|in:normal_user,doctor',
            'certificate' => 'required_if:role,doctor|file',
        ]);

        // Create the user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Hash the password for security
            'role' => $request->role,
        ]);

        // If the user is a doctor, handle the certificate upload
        if ($request->role === 'doctor' && $request->hasFile('certificate')) {
            $path = $request->file('certificate')->store('certificates', 'public');
            DoctorCertificate::create([
                'user_id' => $user->id,
                'certificate_path' => $path,
            ]);
        }

        return response()->json(['message' => 'Registration successful'], 201);
    }

    /**
     * Handle user login and store session.
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        // Attempt to log in the user
        $credentials = $request->only(['email', 'password']);

        if (!Auth::attempt($credentials)) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }

        // Store user in session
        $request->session()->put('user', Auth::user());

        return response()->json(['message' => 'Login successful.']);
    }

    /**
     * Handle user logout and destroy the session.
     */
    public function logout(Request $request)
    {
        // Forget the user session
        $request->session()->forget('user');
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json(['message' => 'Logout successful.']);
    }
}
