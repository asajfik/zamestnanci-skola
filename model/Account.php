<?php

class Account extends Model
{

    private $db;

    public function __construct()
    {
        $this->db = $this->getDB();
    }

    public function isLogged()
    {
        return isset($_SESSION['account']);
    }

    public function getLogged()
    {
        if (!$this->isLogged()) {
            return null;
        }
        return $_SESSION['account'];
    }

    public function isAdmin()
    {
        if (!$this->isLogged()) {
            return false;
        }
        return $_SESSION['account']['user_type'] == 'admin';
    }

    public function login($email, $password)
    {

        $stmt = $this->db->prepare('SELECT employees.*, positions.name AS position_name, departments.name AS department_name FROM employees JOIN positions ON employees.position_id = positions.id JOIN departments ON employees.department_id = departments.id WHERE employees.email = :email');
        $stmt->execute(params: ['email' => $email]);
        $user = $stmt->fetch();

        if (!$user || !password_verify($password, $user['password'])) {
            return 'Špatné jméno nebo heslo';
        }

        $_SESSION['account'] = $user;

    }

    public function logout()
    {
        unset($_SESSION['account']);
        session_destroy();
    }
}
