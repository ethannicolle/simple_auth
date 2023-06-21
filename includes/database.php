<?php

const DBHOST = 'localhost';
const DBUSER = 'root';
const DBPASS = '';
const DBNAME = 'test_db';

$dsn = 'mysql:host=' . DBHOST . ';dbname=' . DBNAME;

try{
    $db = new PDO($dsn, DBUSER, DBPASS);
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
}catch(PDOException $e) {
    die($e->getMessage());
}