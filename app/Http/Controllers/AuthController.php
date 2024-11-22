<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\DoctorCertificate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|in:normal_user,doctor',
            'certificate' => 'required_if:role,doctor|file',
        ]);

        $user = User::create($request->only(['name', 'email', 'password', 'role']));

        if ($request->role === 'doctor' && $request->hasFile('certificate')) {
            $path = $request->file('certificate')->store('certificates', 'public');
            DoctorCertificate::create([
                'user_id' => $user->id,
                'certificate_path' => $path,
            ]);
        }

        return response()->json(['message' => 'Registration successful'], 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if (!Auth::attempt($request->only(['email', 'password']))) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }

        $token = $request->user()->createToken('auth_token')->plainTextToken;
        return response()->json(['token' => $token, 'token_type' => 'Bearer']);
    }
}
