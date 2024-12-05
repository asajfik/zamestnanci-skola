<?php

class Controller
{

    public function model($model)
    {
        require_once '../model/' . $model . '.php';
        return new $model();
    }

    public function view($view, $data = [])
    {
        $accountModel = $this->model('Account');
        $data['isLogged'] = $accountModel->isLogged();
        if ($data['isLogged']) {
            $data['user'] = $accountModel->getUser();
        }

        if (is_array($data)) {
            extract($data);
        }
        require_once '../view/head.php';
        require_once '../view/header.php';
        require_once '../view/' . $view . '.php';
        require_once '../view/footer.php';
    }
}
