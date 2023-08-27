<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\UserLogin;
use App\Repository\Users;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function __construct(private readonly Users $users)
    {
    }

    public function loginUser(UserLogin $request)
    {
        try {
            $request->validated();

            if (!Auth::attempt($request->only(['email', 'password']))) {
                return response()->json([
                    'status' => false,
                    'errors' => ['Email & Password does not match with our record.'],
                ], 401);
            }
            $user = $this->users->findByEmail($request->email);

            return response()->json([
                'status' => true,
                'token' => $user->createToken("API TOKEN")->plainTextToken
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'errors' => [$th->getMessage()]
            ], 500);
        }
    }
}
