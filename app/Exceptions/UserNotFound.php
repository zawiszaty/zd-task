<?php

namespace App\Exceptions;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UserNotFound extends NotFoundHttpException
{
    public function __construct()
    {
        parent::__construct('User not found.');
    }
}
