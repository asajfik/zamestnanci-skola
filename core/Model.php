<?php
class Model

{
    public function getDB()
    {
        return Database::getInstance();
    }

    public function isLogged()
    {
        return isset($_SESSION['account']);
    }

    public function getLogged()
    {
        if (!$this->isLogged()) {
            return null;
        }
        return $_SESSION['account'];
    }

    public function isAdmin()
    {
        if (!$this->isLogged()) {
            return false;
        }
        return $_SESSION['account']['isAdmin'] == 1;
    }
}
