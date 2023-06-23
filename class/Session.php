<?php

session_start();

class Session
{

    // CHECK IF A SESSION EXIST
    public static function sessionExists($key): bool
    {
        return isset($_SESSION[$key]);
    }
    // SESSION SETTER
    public static function setSession($key, $value)
    {
        $_SESSION[$key] = $value;
    }
    // SESSION GETTER
    public static function getSession($key)
    {
        if(!Session::sessionExists($key)) return false;
        return $_SESSION[$key];
    }

    public static function dropSession()
    {
        session_unset();
    }

}