<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . 'class' . DIRECTORY_SEPARATOR . 'Session.php';
$userSession = Session::getSession('user');

if ($userSession) {
    var_dump($userSession);
    echo('<a href="./logout.php">Log out</a>');
    exit;
}
echo 'Not logged in! <a href="./login.php">Log in</a> <a href="./register.php">Register</a>';

