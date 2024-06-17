<?php

require_once __DIR__ . '/../src/vendor/autoload.php';
/* application boostrap */
$app = require_once __DIR__ . '/../src/conf/bootstrap.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$app->run();
