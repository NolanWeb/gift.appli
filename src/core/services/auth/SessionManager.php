<?php

namespace gift\appli\core\services\auth;
class SessionManager
{
    public function login($user)
    {
        $_SESSION['user'] = $user;
    }

    public function logout()
    {
        unset($_SESSION['user']);
    }

    public function isLoggedIn()
    {
        return isset($_SESSION['user']);
    }
}