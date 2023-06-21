<?php

session_start();

if(isset($_SESSION['username'])){
    echo 'Hey ' . $_SESSION['username'];
    exit;
}

echo 'Not logged in! <a href="./register.php">Register</a>';