<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    // POST /api/register
    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'recaptcha_token' => 'required|string',
        ]);

        $this->verifyRecaptcha($data['recaptcha_token']);

        $user = User::create([
            'name' => $data['name'],
            'prenom' => $data['prenom'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        return response()->json([
            'user' => $user,
            'token' => $user->createToken('api_token')->plainTextToken,
        ], 201);
    }

    // POST /api/login
    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'recaptcha_token' => 'required|string',
        ]);

        $this->verifyRecaptcha($data['recaptcha_token']);

        $user = User::where('email', $data['email'])->first();

        if (!$user || !Hash::check($data['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Identifiants incorrects.'],
            ]);
        }

        return response()->json([
            'user' => $user,
            'token' => $user->createToken('api_token')->plainTextToken,
        ]);
    }

    // POST /api/logout
    public function logout(Request $request)
    {
        $user = $request->user();
        if ($user && $request->user()->currentAccessToken()) {
            $request->user()->currentAccessToken()->delete();
        }

        return response()->json(['message' => 'Déconnecté']);
    }

    private function verifyRecaptcha(string $token): void
    {
        $secret = config('services.recaptcha.secret') ?: env('RECAPTCHA_SECRET_KEY');
        if (!$secret) {
            throw ValidationException::withMessages([
                'recaptcha_token' => ['reCAPTCHA non configuré.'],
            ]);
        }

        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => $secret,
            'response' => $token,
        ]);

        $captcha = $response->json();

        if (!($captcha['success'] ?? false)) {
            throw ValidationException::withMessages([
                'recaptcha_token' => ['Captcha invalide.'],
            ]);
        }
    }
}
