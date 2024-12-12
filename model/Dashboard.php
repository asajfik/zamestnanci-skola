<?php

require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Dashboard extends Model
{
    private $db;

    public function __construct()
    {
        $this->db = $this->getDB();
    }

    public function getEmployees(): array
    {
        $query = "SELECT employees.*, positions.name AS position_name, departments.name AS department_name
                  FROM employees
                  JOIN positions ON employees.position_id = positions.id
                  JOIN departments ON employees.department_id = departments.id";

        $stmt = $this->db->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getDepartments(): array
    {
        $query = "SELECT * FROM departments";

        $stmt = $this->db->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPositions(): array
    {
        $query = "SELECT * FROM positions";

        $stmt = $this->db->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addEmployee(string $name, string $email, int $position_id, int $department_id, int $salary, string $start_date): void
    {
        try {
            $query = "INSERT INTO employees (name, email, position_id, department_id, salary, start_date)
                  VALUES (:name, :email, :position_id, :department_id, :salary, :start_date)";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':position_id', $position_id, PDO::PARAM_INT);
            $stmt->bindParam(':department_id', $department_id, PDO::PARAM_INT);
            $stmt->bindParam(':salary', $salary, PDO::PARAM_INT);
            $stmt->bindParam(':start_date', $start_date, PDO::PARAM_STR);
            $stmt->execute();
        } catch (PDOException $e) {
            error_log("Nepodařilo se přidat zaměstnance: " . $e->getMessage());
        }

        $userId = $this->db->lastInsertId();

        $token = bin2hex(random_bytes(32));

        $this->saveRegistrationToken($userId, $token);

        $registrationUrl = "http://zamestnanci.local/account/register/" . $token;

        $this->sendRegistrationEmail($email, $name, $registrationUrl);
    }

    public function editEmployee($id, $name, $email, $position_id, $department_id, $salary, $start_date)
    {
        $query = "UPDATE employees SET name = :name, email = :email, position_id = :position_id, department_id = :department_id, salary = :salary, start_date = :start_date WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':position_id', $position_id, PDO::PARAM_INT);
        $stmt->bindParam(':department_id', $department_id, PDO::PARAM_INT);
        $stmt->bindParam(':salary', $salary, PDO::PARAM_INT);
        $stmt->bindParam(':start_date', $start_date, PDO::PARAM_STR);
        $stmt->execute();
    }

    public function deleteEmployee($id)
    {
        $query = "DELETE FROM employees WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }

    public function addDepartment(string $name): void
    {
        $query = "INSERT INTO departments (name) VALUES (:name)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':name', $name);
        $stmt->execute();
    }

    public function addPosition(string $name): void
    {
        $query = "INSERT INTO positions (name) VALUES (:name)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':name', $name);
        $stmt->execute();
    }

    public function saveRegistrationToken($userId, $token)
    {
        $query = "INSERT INTO registration_tokens (user_id, token, created_at) 
              VALUES (:user_id, :token, NOW())";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':token', $token);
        $stmt->execute();
    }

    private function sendRegistrationEmail($email, $name, $registrationUrl)
    {
        $mail = new PHPMailer(TRUE);

        try {

            // Nastavení e-mailu
            $mail->setFrom(MAIL_USER, 'NEODPOVÍDAT');
            $mail->addAddress($email);
            $mail->Subject = 'Váš odkaz pro registraci';
            $mail->isHTML(true);

            ob_start();

?>
            <h1>Vítejte, $name!</h1>
            <p>Klikněte na následující odkaz pro dokončení registrace a nastavení hesla:</p>
            <a href='<?= $registrationUrl ?>'><?= $registrationUrl ?></a>

<?php

            $mail->Body = ob_get_clean();
            $mail->isSMTP();
            $mail->Host = MAIL_HOST;
            $mail->Port = MAIL_PORT;
            $mail->SMTPAuth = true;
            $mail->SMTPSecure = MAIL_SECURE;
            $mail->Username = MAIL_USER;
            $mail->Password = MAIL_PSW;

            $mail->send();
        } catch (Exception $e) {
            error_log("E-mail nemohl být odeslán. Chyba: {$mail->ErrorInfo}");
        }
    }
}
