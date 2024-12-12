<?php

class DashboardController extends Controller
{

    private $model;

    public function __construct()
    {
        $this->model = $this->model('Dashboard');
    }

    public function index()
    {
        if (!$this->model->isLogged()) {
            header('Location: /');
            exit;
        }

        $sortBy = $_GET['sort_by'] ?? 'id';
        $order = $_GET['order'] ?? 'ASC';
        $department = $_GET['department'] ?? null;
        $position = $_GET['position'] ?? null;
        $minSalary = $_GET['min_salary'] ?? null;
        $maxSalary = $_GET['max_salary'] ?? null;
        $search = $_GET['search'] ?? null;

        $data = [
            'title' => 'Dashboard',
            'account' => $this->model->getLogged(),
            'employees' => $this->model->getEmployees($sortBy, $order, $department, $position, $minSalary, $maxSalary, $search),
            'departments' => $this->model->getDepartments(),
            'positions' => $this->model->getPositions(),
            'sortBy' => $sortBy,
            'order' => $order,
        ];

        $this->view('dashboard/index', $data);
    }

    public function addEmployee()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $email = $_POST['email'] ?? '';
            $position_id = $_POST['position_id'] ?? 0;
            $department_id = $_POST['department_id'] ?? 0;
            $salary = $_POST['salary'] ?? 0;
            $start_date = $_POST['start_date'] ?? '';

            if (!empty($name) && !empty($email) && $position_id && $department_id && $salary && $start_date) {
                $this->model->addEmployee($name, $email, $position_id, $department_id, $salary, $start_date);
            }
        }

        header('Location: /dashboard');
        exit;
    }

    public function editEmployee()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;
            $name = $_POST['name'] ?? '';
            $email = $_POST['email'] ?? '';
            $position_id = $_POST['position_id'] ?? 0;
            $department_id = $_POST['department_id'] ?? 0;
            $salary = $_POST['salary'] ?? 0;
            $start_date = $_POST['start_date'] ?? '';

            if ($id && !empty($name) && !empty($email) && $position_id && $department_id && $salary && $start_date) {
                $this->model->editEmployee($id, $name, $email, $position_id, $department_id, $salary, $start_date);
                header('Location: /dashboard');
                exit;
            }
        }

        header('Location: /dashboard');
        exit;
    }

    public function deleteEmployee()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;

            if ($id) {
                $this->model->deleteEmployee($id);
                header('Location: /dashboard');
                exit;
            }
        }

        header('Location: /dashboard');
        exit;
    }

    public function addDepartment()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';

            if (!empty($name)) {
                $this->model->addDepartment($name);
                header('Location: /dashboard');
                exit;
            }
        }

        header('Location: /dashboard');
        exit;
    }

    public function addPosition()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';

            if (!empty($name)) {
                $this->model->addPosition($name);
                header('Location: /dashboard');
                exit;
            }
        }

        header('Location: /dashboard');
        exit;
    }
}
