<?php

namespace gift\appli\utils;

use Exception;

class CsrfService
{
    public static function generate(): string
    {
        if (!session_id()) {
            session_start();
        }
        $token = bin2hex(random_bytes(32));
        $_SESSION['csrf_token'] = $token;
        return $token;
    }

    public static function check(string $token): bool
    {
        if (!session_id()) {
            session_start();
        }
        if (!isset($_SESSION['csrf_token']) || $_SESSION['csrf_token'] !== $token) {
            return false;
        }
        unset($_SESSION['csrf_token']);
        return true;
    }
}
