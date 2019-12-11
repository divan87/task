<?php
/**
 * Контролер сущности заданий
 */

include_once ROOT.'/models/Task.php';  //Подключаем модель заданий
include_once ROOT.'/models/User.php';  //Подключаем модель пользователя

class TaskController
{
	
	//Получить страницу заданий

	public function getPage($page = 0, $sort = 'id', $typesort = 'asc')
	{
		$this->columns = Task::getNamesColumns('tasks');  //Получаем названия столбцов
		
		if ($page == 0) {
			$page = 1;
		}

		if (!in_array($sort, $this->columns)) {
			$sort = 'id';
		}

		if ($typesort != 'asc' and $typesort != 'desc') {
			$typesort = 'asc';
		}


		$this->limit = 3;
		$this->count = Task::getCountTasks();
		$this->total_pages = ceil($this->count / $this->limit);
		$this->offset = ($page - 1) * $this->limit;
		$this->sort = $sort;
		$this->typesort = $typesort;

		$result = Task::getTasklist($this->offset, $this->limit, $this->total_pages, $this->sort, $page, $this->typesort);

		return $result;
	}

	//Вывод страницы заданий

	public function actionIndex($page, $sort, $typesort)
	{
		$taskList = array();
		$taskList = $this->getPage($page, $sort, $typesort);

		require_once(ROOT . '/views/task/index.php');

		return true;
	}

	//Проверка E-Mail
	public function checkMail($email)
	{
		if (filter_var($email, FILTER_VALIDATE_EMAIL))
		{
			return true;
		}
		else return false;
	}

	//Очистка переменной от спец. символов
	public function clearVar($var) {
		$var = strip_tags($var);
		$var = htmlspecialchars($var, ENT_QUOTES);
		return $var;
	}


	//Действие создания задания
	public function actionCreate()
	{
		$success = false;
		if (isset($_POST['ok'])) {

			$user = $this->clearVar($_POST['user']);
			$email = $this->clearVar($_POST['email']);
			$text = $this->clearVar($_POST['text']);

			if (!empty($user) && !empty($email) && !empty($text)) {
				if ($this->checkMail($email)) {
					$data = array(
							'user' => $user,
							'text' => $text,
							'email' => $email
							);					
					$errors = false;
					$success = true;
					$result = Task::createTask($data);
					require_once(ROOT . '/views/task/create.php');
					return true;
				}
				else $errors[] = 'Проверьте поле E-Mail';
				require_once(ROOT . '/views/task/create.php');
				return true;				
			}
			else $errors[] = 'Заполните пустые поля';
			require_once(ROOT . '/views/task/create.php');
			return true;
		}
		require_once(ROOT . '/views/task/create.php');
		return true;
	}

	//Действие редактирования задания
	public function actionEdit($id)
	{
		$success = false;
		if (isset($_POST['ok']) && isset($id) && is_numeric($id)) {	
			$task = Task::getTaskById($id);	
			if (!User::isGuest()) 
			{	
				$user = $this->clearVar($_POST['user']);
				$email = $this->clearVar($_POST['email']);
				$text = $this->clearVar($_POST['text']);

				if ($text == $task['text'] && $task['edit'] == 0) {
					$is_changed = 0;
				} else $is_changed = 1;

				if (isset($_POST['status']) && $_POST['status'] == 'on')
					$status = 1;
				else $status = 0;

				if (!empty($user) && !empty($email) && !empty($text)) {
					if ($this->checkMail($_POST['email'])) {
						$data = array(
								'user' => $user,
								'text' => $text,
								'email' => $email,
								'status' => $status,
								'is_changed' => $is_changed,
								'id' => $id
								);					
						$errors = false;
						$success = true;
						$result = Task::editTask($data);
						$task = Task::getTaskById($id);	
						require_once(ROOT . '/views/task/edit.php');
						return true;
					}
					else $errors[] = 'Проверьте поле E-Mail';
					require_once(ROOT . '/views/task/edit.php');
					return true;				
				}
				else $errors[] = 'Заполните пустые поля';
				require_once(ROOT . '/views/task/edit.php');
				return true;
			}
			else $errors[] = 'Вы не авторизованы как администратор';
			require_once(ROOT . '/views/task/edit.php');
			return true;
		}

		if (isset($id) && is_numeric($id)) {
			$task= Task::getTaskById($id);
		}

		require_once(ROOT . '/views/task/edit.php');
		return true;
	}
}
?>