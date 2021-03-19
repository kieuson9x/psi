<?php
class Employee
{
    private $db;
    public function __construct()
    {
        $this->db = new Database;
    }

    public function showByLevel($levelId)
    {
        $this->db->query('SELECT * FROM employees where level_id = :level_id');

        $this->db->bind(':level_id', $levelId);

        $results = $this->db->resultSet();

        return $results;
    }

    public function register($data)
    {
        $this->db->query('INSERT INTO employees (user_name, password, full_name) VALUES(:user_name, :password, :full_name)');

        //Bind values
        $this->db->bind(':user_name', $data['user_name']);
        $this->db->bind(':full_name', $data['full_name']);
        $this->db->bind(':password', $data['password']);

        //Execute function
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function login($user_name, $password)
    {
        $this->db->query('SELECT * FROM employees WHERE user_name = :user_name');

        //Bind value
        $this->db->bind(':user_name', $user_name);

        $row = $this->db->single();

        $hashedPassword = $row->password;

        if (password_verify($password, $hashedPassword)) {
            return $row;
        } else {
            return false;
        }
    }

    //Find user by email. Email is passed in by the Controller.
    public function findUserByEmail($email)
    {
        //Prepared statement
        $this->db->query('SELECT * FROM users WHERE email = :email');

        //Email param will be binded with the email variable
        $this->db->bind(':email', $email);

        //Check if email is already registered
        if ($this->db->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }
}
