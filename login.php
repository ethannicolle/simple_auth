<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'database.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'class' . DIRECTORY_SEPARATOR . 'Users.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'class' . DIRECTORY_SEPARATOR . 'Session.php';

$error = '';
$users = new Users($db);

const MIN_USERNAME_LENGTH = 5;
const MAX_USERNAME_LENGTH = 20;
const MIN_PASSWORD_LENGTH = 8;
const MAX_PASSWORD_LENGTH = 20;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username = strip_tags($_POST['username']);
    $password = $_POST['password'];

    if (strlen($username) < MIN_USERNAME_LENGTH || strlen($username) > MAX_USERNAME_LENGTH) $error = 'Invalid username or password.';
    if (strlen($password) < MIN_USERNAME_LENGTH || strlen($password) > MAX_USERNAME_LENGTH) $error = 'Invalid username or password.';

    if ($username && $password) {

        if (empty($errors)) {

            $results = $users->logUser($username, $password);
            switch ($results) {
                default:
                    Session::setSession('user',  [
                        'id' => $results['id'],
                        'username' => $username
                    ]);
                    header('Location: ./index.php');
                    break;
                case false:
                    $error = 'Invalid username or password.';
                    break;
            }
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log in form</title>
</head>

<body>
    <?php
    if (isset($error)) {
        echo $error;
    }
    ?>
    <form method="post">
        <div>
            <label for="username">Username</label>
            <input type="text" name="username" id="username">
        </div>
        <div>
            <label for="password">Password</label>
            <input type="password" name="password" id="password">
        </div>
        <button type="submit">Log in</button>
    </form>

</body>

</html>