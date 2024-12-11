<?php

class DashboardController extends Controller
{

    private $model;

    public function __construct()
    {
        $this->model = $this->model('Dashboard');
    }
}
