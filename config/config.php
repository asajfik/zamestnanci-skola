<?php

session_start();

header('Content-Type: text/html; charset=utf-8');
setlocale(LC_ALL, 'cs_CZ.utf8');
date_default_timezone_set('Europe/Prague');
mb_internal_encoding('utf-8');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

define('DB_TYPE', 'mysql');
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'company_management');

define('MAIL_USER', 'info@rodicaky.cz');
define('MAIL_PSW', '!Schuzky2024!');
define('MAIL_HOST', 'mail.rodicaky.cz');
define('MAIL_PORT', 465);
define('MAIL_SECURE', 'ssl');