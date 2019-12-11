<?php
/**
 * Модель сущности пользователя
 */
class User
{
	
	//Хеширование пароля
	public function generateHash($password) {
		if (defined("CRYPT_BLOWFISH") && CRYPT_BLOWFISH) {
			$salt = '$2y$11$' . substr(md5(uniqid(rand(), true)), 0, 22);
			return crypt($password, $salt);
		}
	}

	//Проверка имени
	public static function checkName($name)
	{
		if (strlen($name) >= 2) return true;
		else return false;
	}

	//Проверка длины пароля
	public static function checkPassword($password)
	{
		if (strlen($password) >= 6) return true;
		else return false;
	}

	//Проверка E-Mail на валидность
	public static function checkEmail($email)
	{
		if (filter_var($email, FILTER_VALIDATE_EMAIL)) return true;
		else return false;
	}

	//Проверка на существования пользователя с указанным login
	public static function checkUserLogin($login)
	{
		$db = Db::getConnection();
		$sql = 'SELECT * FROM users WHERE login = :login';
		$result = $db->prepare($sql);
		$result->bindParam(':login', $login, PDO::PARAM_STR);
		$result->setFetchMode(PDO::FETCH_ASSOC);
		$result->execute();
		return $result->fetch();
	}

	//Проверка на авторизацию
	public static function isGuest()
	{
		if (isset($_SESSION['user'])) return false;
		else return true;
	}

	//Авторизация
	public static function auth($userId)
	{
		// Записываем идентификатор пользователя в сессию
		$_SESSION['user'] = $userId;
	}
}
?>