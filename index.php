<?php

session_start();

declare(strict_types=1);

header('Content-Type: text/html; charset=utf-8');
setlocale(LC_ALL, 'cs_CZ.utf8');
date_default_timezone_set('Europe/Prague');
mb_internal_encoding('utf-8');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'config/config.php';
require_once 'core/Database.php';
require_once 'core/App.php';
require_once 'core/Controller.php';
require_once 'core/Model.php';


$app = new App();
