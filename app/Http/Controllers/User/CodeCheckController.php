<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\CodeCheck;
use App\Repository\ResetCodePasswords;
use App\Repository\Users;

class CodeCheckController extends Controller
{
    public function __construct(private readonly Users $users, private readonly ResetCodePasswords $resetCodePassword)
    {
    }

    public function __invoke(CodeCheck $request)
    {
        $request->validated();
        $passwordReset = $this->resetCodePassword->findByCode($request->code);

        if ($passwordReset->created_at > now()->addHour()) {
            $this->resetCodePassword->remove($passwordReset);

            return response(['message' => 'password code expired'], 422);
        }
        $user = $this->users->findByEmail($passwordReset->email);
        $user->password = $request->password;
        $this->users->save($user);
        $this->resetCodePassword->remove($passwordReset);

        return response(['status' => 'ok'], 200);
    }
}
