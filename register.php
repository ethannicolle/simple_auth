<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'database.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'class' . DIRECTORY_SEPARATOR . 'Users.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'class' . DIRECTORY_SEPARATOR . 'Session.php';

const MIN_USERNAME_LENGTH = 5;
const MAX_USERNAME_LENGTH = 20;
const MIN_PASSWORD_LENGTH = 8;
const MAX_PASSWORD_LENGTH = 20;

$errors = [];
$users = new Users($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username = strip_tags($_POST['username']);
    $password = $_POST['password'];

    if (strlen($username) < MIN_USERNAME_LENGTH || strlen($username) > MAX_USERNAME_LENGTH) $errors[] = 'Username must contain between ' . MIN_USERNAME_LENGTH . ' and ' . MAX_USERNAME_LENGTH . ' characters.';
    if (strlen($password) < MIN_USERNAME_LENGTH || strlen($password) > MAX_USERNAME_LENGTH) $errors[] = 'Password must contain between ' . MIN_PASSWORD_LENGTH . ' and ' . MAX_PASSWORD_LENGTH . ' characters.';

    if ($username && $password) {

        if (empty($errors)) {

            $results = $users->createUsers($username, $password);
            switch ($results) {
                case true:
                    Session::setSession('user', [
                        'id' => $db->lastInsertId(),
                        'username' => $username
                    ]);
                    header('Location: ./index.php');
                    break;
                default:
                    $errors[] = 'This username already exists.';
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
    <title>Register form</title>
</head>

<body>
    <?php
    if (isset($errors)) {
        foreach ($errors as $error) {
            echo $error;
        }
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
        <button type="submit">Register</button>
    </form>

</body>

</html>