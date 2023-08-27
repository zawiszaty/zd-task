<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserRegister;
use App\Models\User;
use App\Repository\Users;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class RegisterController extends Controller
{
    public function __construct(private readonly Users $users)
    {
    }

    protected function create(array $data): User
    {
        $user = new User([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
        $this->users->save($user);

        return $user;
    }

    public function register(UserRegister $register): Response
    {
        $register->validated();
        $user = $this->create($register->all());

        return response()->json($user, Response::HTTP_CREATED);
    }
}
