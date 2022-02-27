<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LoginController extends Controller
{
    public function show(): View
    {
        return view('auth.login');
    }

    public function store(Request $request): JsonResponse
    {
        $this->validate($request, [
            'username' => ['string', 'required', 'max:255', 'exists:users'],
            'password' => ['string', 'required'],
        ]);

        $credentials = [
            'username' => $request->username,
            'password' => $request->password,
        ];

        if (Auth::attempt($credentials)) {
            return redirect('/');
        } else {
            return response()->json([
                'message' => 'Invalid Credentials.',
            ], 401);
        }
    }
}
