<?php

class AccountController extends Controller
{

    private $model;

    public function __construct()
    {
        $this->model = $this->model('Account');
    }

    public function index()
    {
        if ($this->model->isLogged()) {
            header('Location: /dashboard/');
        }

        $data = [
            'title' => 'Přihlášení',
            'csrf_token' => $this->getCsrfToken(),
        ];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (!$this->checkCsrfToken($_POST['csrf_token'])) {
                header('Location: ' . $_SERVER['REQUEST_URI']);
            }
            header:
            $data['error'] = $this->model->login($_POST['email'], $_POST['password']);

            header('Location: /');
        }

        $this->view('account/login', $data);
    }

    public function logout()
    {
        if ($this->model->isLogged()) {
            header('Location: /dashboard/');
        }

        $this->model->logout();

        header('Location: /');
    }

    public function register(array $params): void
    {

        $token = $params[0] ?? '';

        if ($this->model->isLogged()) {
            $this->model->logout();
        }

        $data = [
            'title' => 'Registrace'
        ];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $password = $_POST['password'] ?? '';
            $passwordConfirm = $_POST['password_confirm'] ?? '';

            $data['error'] = $this->model->register($token, $password, $passwordConfirm);

            header('Location: /');
            exit;
        }

        $this->view('account/register', $data);
    }

    private function getCsrfToken()
    {
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }

    private function checkCsrfToken($token)
    {
        return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
    }
}
