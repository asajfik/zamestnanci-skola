<?php

class App
{

    protected $controller = 'account';
    protected $method = 'index';
    protected $params = '';

    public function __construct()
    {
        $url = $this->parseUrl();

        if (file_exists('./controller/' . ucfirst($url[0]) . 'Controller.php')) {
            try {
                $this->controller = ucfirst($url[0]) . 'Controller';
                unset($url[0]);

                require_once './controller/' . $this->controller . '.php';
                $this->controller = new $this->controller;

                if (isset($url[1])) {
                    if (method_exists($this->controller, $url[1])) {
                        $this->method = $url[1];
                        unset($url[1]);
                    } else {
                        var_dump('Metoda neexistuje');
                    }
                }

                $this->params = $url ? array_values($url) : [];
                call_user_func_array([$this->controller, $this->method], [$this->params]);
            } catch (Exception $e) {
                var_dump($e);
            }
        } else {
            var_dump('Kontroler neexistuje ');
        }
    }

    public function parseUrl()
    {
        if (isset($_GET['url'])) {
            $url = urldecode($_GET['url']);
            $url = rtrim($url, '/');
            $url = preg_replace('/[^a-zA-Z0-9ěščřžýáíéůúťňĚŠČŘŽÝÁÍÉŮÚŤŇ\-\/]/', '', $url);

            return explode('/', $url);
        } else {
            return array($this->controller, $this->method, $this->params);
        }
    }
}
