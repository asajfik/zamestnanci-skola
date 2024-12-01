<?php

class App
{

    protected $controller = 'zamestnanci';
    protected $method = 'index';
    protected $params = '';

    public function __construct()
    {
        $url = $this->parseUrl();

        if (file_exists('../controllers/' . ucfirst($url[0]) . 'Controller.php')) {
            $this->controller = ucfirst($url[0]) . 'Controller';
            unset($url[0]);

            require_once '../controllers/' . $this->controller . '.php';
            $this->controller = new $this->controller;

            if (isset($url[1])) {
                if (method_exists($this->controller, $url[1])) {
                    $this->method = $url[1];
                    unset($url[1]);
                } else {
                    var_dump('Metoda neexistuje');
                }
            }

            try {
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
            // Dekóduje URL pro zachování českých znaků
            $url = urldecode($_GET['url']);

            // Odstraní závěrečné lomítko
            $url = rtrim($url, '/');

            // Povolené znaky: české znaky, písmena, čísla, pomlčky a lomítka
            $url = preg_replace('/[^a-zA-Z0-9ěščřžýáíéůúťňĚŠČŘŽÝÁÍÉŮÚŤŇ\-\/]/', '', $url);

            return explode('/', $url);
        } else {
            return array($this->controller, $this->method, $this->params);
        }
    }
}
