<?php


class Users
{

    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function createUsers(string $name, string $password): string
    {

        if ($this->userExists($name)) return 'This username already exists.';

        $hashedPassword = password_hash($password, PASSWORD_ARGON2ID);

        $sql = 'INSERT INTO `users`(`username`, `password`) VALUES (:username, :password)';
        $query = $this->db->prepare($sql);
        $query->bindValue(':username', $name, PDO::PARAM_STR);
        $query->bindValue(':password', $hashedPassword, PDO::PARAM_STR);
        $query->execute();

        return 'Success';
    }
    
    public function logUser(string $name, string $password)
    {

        $errorMessage = 'Invalid username or password.';
        if(!$this->userExists($name)) return $errorMessage;

        $sql = 'SELECT * FROM `users` WHERE `username` = :username';
        $query = $this->db->prepare($sql);
        $query->bindValue(':username', $name, PDO::PARAM_STR);
        $query->execute();

        $user = $query->fetch();
        if(!password_verify($password, $user['password'])) return $errorMessage;

        return $user;
    }

    private function userExists(string $name)
    {

        $sql = 'SELECT COUNT(*) FROM `users` WHERE username = :username';
        $query = $this->db->prepare($sql);
        $query->bindValue(':username', $name, PDO::PARAM_STR);
        $query->execute();

        return ($query->fetchColumn() > 0);
    }
}
