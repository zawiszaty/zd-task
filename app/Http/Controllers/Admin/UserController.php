<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserRolesEdit;
use App\Models\User;
use App\Repository\Users;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function __construct(private readonly \App\Service\User $user)
    {
    }

    public function list(Request $request): Response
    {
        $users = $this->user->list($request->get('per_page', 10));

        return response()->json(['user' => $users]);
    }

    public function editRole(UserRolesEdit $userRolesEdit, int $userId): Response
    {
        $userRolesEdit->validated();
        $this->user->edit($userId, $userRolesEdit->get('roles'));

        return response()->json(['user' => $this->user->find($userId)]);
    }
}
