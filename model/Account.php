<?php

class Account extends Model
{

    private $db;

    public function __construct()
    {
        $this->db = $this->getDB();
    }

    public function login($email, $password)
    {

        $stmt = $this->db->prepare('SELECT employees.*, positions.isAdmin AS isAdmin, positions.name AS position_name, departments.name AS department_name FROM employees JOIN positions ON employees.position_id = positions.id JOIN departments ON employees.department_id = departments.id WHERE employees.email = :email');
        $stmt->execute(params: ['email' => $email]);
        $user = $stmt->fetch();

        if (!$user || !password_verify($password, $user['password'])) {
            return 'Špatné jméno nebo heslo';
        }

        $_SESSION['account'] = $user;
        $_SESSION["isAdmin"] = $this->isAdmin();
    }

    public function logout()
    {
        unset($_SESSION['account']);
        session_destroy();
    }

    public function register($token, $password, $passwordConfirm)
    {

        if ($password !== $passwordConfirm) {
            return 'Hesla se neshodují';
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $query = "SELECT user_id FROM registration_tokens WHERE token = :token";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':token', $token);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            $userId = $result['user_id'];

            $updateQuery = "UPDATE employees SET password = :password WHERE id = :id";
            $updateStmt = $this->db->prepare($updateQuery);
            $updateStmt->bindParam(':password', $hashedPassword);
            $updateStmt->bindParam(':id', $userId, PDO::PARAM_INT);

            if ($updateStmt->execute()) {

                $deleteQuery = "DELETE FROM registration_tokens WHERE token = :token";
                $deleteStmt = $this->db->prepare($deleteQuery);
                $deleteStmt->bindParam(':token', $token);
                $deleteStmt->execute();

                $query = "SELECT employees.*, positions.name AS position_name, departments.name AS department_name FROM employees JOIN positions ON employees.position_id = positions.id JOIN departments ON employees.department_id = departments.id WHERE employees.id = :id";
                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':id', $userId, PDO::PARAM_INT);
                $stmt->execute();
                $user = $stmt->fetch();
                $_SESSION['account'] = $user;
                return;
            }
        } else {
            return 'Neplatný token';
        }
    }
}
