<?php
/**
 * Класс подключения к БД
 */
class Db
{
	
	public static function getConnection()
	{
		$paramsPath = ROOT . '/config/db_params.php';
		$params = include($paramsPath); //Берем параметры из конфигурационного файла

		$dsn = "mysql:host={$params['host']};dbname={$params['dbname']};";
		$db = new PDO($dsn, $params['user'], $params ['password']);
		$db->exec("set names utf8");  //Меняем кодировку сервера

		return $db;
	}
}
?>