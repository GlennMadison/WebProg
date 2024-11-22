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
        'name' => 'required',
        'email' => 'required|email|unique:users',
        'password' => 'required|min:6',
        'role' => 'required|in:normal_user,doctor',
        'certificate' => 'required_if:role,doctor|file'
    ]);

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => bcrypt($request->password),
        'role' => $request->role,
    ]);

    if ($request->role === 'doctor' && $request->hasFile('certificate')) {
        $path = $request->file('certificate')->store('certificates', 'public');
        DoctorCertificate::create([
            'user_id' => $user->id,
            'certificate_path' => $path,
        ]);
    }

    return response()->json(['message' => 'User registered successfully']);
}

public function login(Request $request)
{
    $credentials = $request->only('email', 'password');
    if (!Auth::attempt($credentials)) {
        return response()->json(['error' => 'Unauthorized'], 401);
    }

    $token = $request->user()->createToken('auth_token')->plainTextToken;
    return response()->json(['access_token' => $token, 'token_type' => 'Bearer']);
}

}
