<?php
//FRONT CONTROLLER

// 1. Общие настройки

ini_set('display_errors', 0);
error_reporting(E_ALL);
session_start();


//2. Подключение файлов системыэ
define('ROOT', dirname(__FILE__));
define('TABLE', 'tasks');
require_once(ROOT . '/components/Router.php');
require_once(ROOT . '/components/Db.php');


//3. Вызов Router
$router = new Router();
$router->run();
?>