<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . 'class' . DIRECTORY_SEPARATOR . 'Session.php';

Session::dropSession();
header('Location: ./index.php');