<?php
class User {
    private int $id;
    private mysqli $db;
    private string $login;
    private string $password;
    private string $firstName;
    private string $lastName;

    public function __construct(string $login, string $password) {
        $this->login = $login;
        $this->password = $password;
        $this->firstName = "";
        $this->lastName = "";
        global $db;
        $this->db = &$db;
    }
    
    public function register() : bool {
        $passwordHash = password_hash($this->password, PASSWORD_ARGON2I);
        $query = "INSERT INTO user VALUES (NULL, ?, ?, ?, ?)";
        $preparedQuery = $this->db->prepare($query); 
        $preparedQuery->bind_param('ssss', $this->login, $passwordHash, 
                                            $this->firstName, $this->lastName);
        $result = $preparedQuery->execute();
        return $result;
        }