<?php

namespace gift\appli\core\services\auth;


use gift\appli\core\domain\entities\User;

class AuthService
{
    public function authenticate($email, $password)
    {
        $user = User::where('user_id', $email)->first();

        if ($user && password_verify($password, $user->password)) {
            return $user;
        } else {
            return null;
        }
    }
}