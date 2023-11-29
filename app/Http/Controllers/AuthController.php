<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{

    public function create()
    {
        return inertia('Auth/Login');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string'
        ]);

        if (!Auth::attempt($data, true)) {

            $user = User::where('email', $data['email'])->first();

            if($user && $request['password'] !== $user->password) {
                throw ValidationException::withMessages([
                    'email' => 'Authentication failed'
                ]);
            }

            Auth::login($user, true);
        }

        $request->session()->regenerate();

        return redirect()->intended('/listing');
    }

    public function destroy( Request $request )
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

}
