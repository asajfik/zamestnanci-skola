<?php

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

    public function getPositions():array
    {
        $query = "SELECT * FROM positions";

        $stmt = $this->db->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
