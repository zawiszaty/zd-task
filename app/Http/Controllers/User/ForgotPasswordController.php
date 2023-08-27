<?php

namespace App\Http\Controllers\User;

use App\Http\Requests\User\ForgotPassword;
use App\Jobs\SendForgotPasswordMail;

class ForgotPasswordController
{
    public function __invoke(ForgotPassword $request)
    {
        $request->validated();
        SendForgotPasswordMail::dispatch($request->email);

        return response(['status' => 'ok'], 200);
    }
}
