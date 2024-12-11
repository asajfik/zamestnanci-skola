<?php

class Controller
{

    public function model(string $model): Object
    {
        require_once './model/' . $model . '.php';
        return new $model();
    }

    public function view(string $view, array $data): void
    {

        if (!empty($data)) {
            extract($data);
        }

        require_once './view/head.php';
        require_once './view/header.php';
        require_once './view/' . $view . '.php';
        require_once './view/footer.php';
    }
}
