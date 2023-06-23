<?php


class Users
{

    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function createUsers(string $name, string $password): bool
    {

        if ($this->userExists($name)) return false;

        $hashedPassword = password_hash($password, PASSWORD_ARGON2ID);

        $sql = 'INSERT INTO `users`(`username`, `password`) VALUES (:username, :password)';
        $query = $this->db->prepare($sql);
        $query->bindValue(':username', $name, PDO::PARAM_STR);
        $query->bindValue(':password', $hashedPassword, PDO::PARAM_STR);
        $query->execute();

        return true;
    }
    
    public function logUser(string $name, string $password)
    {
        if(!$this->userExists($name)) return false;

        $sql = 'SELECT * FROM `users` WHERE `username` = :username';
        $query = $this->db->prepare($sql);
        $query->bindValue(':username', $name, PDO::PARAM_STR);
        $query->execute();

        $user = $query->fetch();
        if(!password_verify($password, $user['password'])) return false;

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
