<?php
/**
 * Контролер сущности пользователя
 */

include_once ROOT.'/models/User.php';   //Подключаем модель пользователя


class UserController
{
	
	//Авторизация пользователя
	public function actionLogin()
	{
		if (isset($_POST['submit'])) {

			$login = $_POST['login'];
			$password = $_POST['password'];
			$errors = false;		

			$check = User::checkUserLogin($login);
			$hashed_password = $check['password'];
			$userId = $check['id'];
			if ($this->verify($password, $hashed_password)) {
				User::auth($userId);
				header("Location: /");
				return true;
			} else $errors[] = 'Неправильные данные для входа на сайт';
			require_once(ROOT . '/views/user/login.php');
		}
		require_once(ROOT . '/views/user/login.php');
		return true;
	}

	//Выход пользователя
	public function actionLogout()
	{
		unset($_SESSION["user"]);
		session_destroy();
		header("Location: /");
		return true;
	}

	//Сверка введенного и правильного пароля
	public function verify($password, $hashedPassword) {
	return crypt($password, $hashedPassword) == $hashedPassword;
	}
}
?>