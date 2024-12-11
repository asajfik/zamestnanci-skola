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
        }

        $data = [
            'title' => 'Dashboard',
            'account' => $this->model->getLogged(),
            'employees' => $this->model->getEmployees(),
            'departments' => $this->model->getDepartments(),
            'positions' => $this->model->getPositions(),
        ];

        $this->view('dashboard/index', $data);
    }
}
