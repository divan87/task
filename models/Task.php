<?php
/**
 * Модель сущности задания
 */
class Task
{
	
	//Вывод всех заданий
	public static function getCountTasks()
	{
		$db = Db::getConnection();
		$sql = "SELECT * FROM `tasks`";
		$result = $db->query($sql);
		return $result->rowCount();
	}

	//Функция вывода наименования столбцов с таблице
	public static function getNamesColumns($table)
	{
		$db = Db::getConnection();
		$columns = array();
		$paramsPath = ROOT . '/config/db_params.php';
		$params = include($paramsPath);
		$dbname = $params['dbname'];

		$sql = "SELECT `COLUMN_NAME` "
		. "FROM `INFORMATION_SCHEMA`.`COLUMNS` "
		. "WHERE `TABLE_SCHEMA`='$dbname' "
		. "AND `TABLE_NAME`='$table';";
		$result = $db->query($sql);
		
		while ($row = $result->fetch()) {
			$columns[] = $row['COLUMN_NAME'];
		}
		return $columns;
	}

	//Создание задания (вставка в таблицу)
	public static function createTask($data)
	{
		if (!empty($data)) {
			$db = Db::getConnection();
			$sql = "INSERT INTO tasks(user, text, email) VALUES (:user, :text, :email)";
			$result = $db->prepare($sql);
			$result->bindParam(':user', $data['user'], PDO::PARAM_STR);
			$result->bindParam(':text', $data['text'], PDO::PARAM_STR);
			$result->bindParam(':email', $data['email'], PDO::PARAM_STR);
			$result->execute();
			return true;
		}
		return false;		
	}

	//Редактирование задания (записи в БД)
	public static function editTask($data)
	{
		if (!empty($data)) {
			$db = Db::getConnection();
			$sql = "UPDATE tasks set user = :user, text = :text, email = :email, status = :status, edit = :is_changed WHERE id = :id";
			$result = $db->prepare($sql);
			$result->bindParam(':user', $data['user'], PDO::PARAM_STR);
			$result->bindParam(':text', $data['text'], PDO::PARAM_STR);
			$result->bindParam(':email', $data['email'], PDO::PARAM_STR);
			$result->bindParam(':status', $data['status'], PDO::PARAM_INT);
			$result->bindParam(':is_changed', $data['is_changed'], PDO::PARAM_INT);
			$result->bindParam(':id', $data['id'], PDO::PARAM_INT);
			$result->execute();
			return true;
		}
		return false;		
	}

	//Возвращаем нужный массив заданий (постранично с опредеенной сортировкой)
	public static function getTaskList($offset, $limit, $total_pages, $sort, $current_page, $typesort)
	{

		$db = Db::getConnection();
		$taskList = array();
		$sql = "SELECT * FROM `tasks` ORDER BY $sort $typesort LIMIT $offset, $limit ";
		$result = $db->prepare($sql);
		$result->bindParam(':sort', $sort, PDO::PARAM_STR);
		$result->bindParam(':typesort', $typesort, PDO::PARAM_STR);
		$result->bindParam(':offset', $offset, PDO::PARAM_INT);
		$result->bindParam(':limit', $limit, PDO::PARAM_INT);
		$result->execute();
		$taskList = $result->fetchAll();

		$taskList[0]['total_pages'] = $total_pages;		//Итоговые значения для передачи в view
		$taskList[0]['current_page'] = $current_page;		
		$taskList[0]['sort'] = $sort;
		$taskList[0]['typesort'] = $typesort;
		//$taskList[0]['columns'] = Task::getNamesColumns('tasks');
		$taskList[0]['columns'] = array(
			'#' => 'id',
			'Пользователь' => 'user',
			'E-Mail' => 'email',
			'Текст' => 'text',
			'Выполнение' => 'status'
		);
		return $taskList;
	}

	//Получить нужное задание по id
	public static function getTaskById($id)
	{
		$db = Db::getConnection();
		$sql = "SELECT * FROM `tasks` WHERE id = :id";
		$result = $db->prepare($sql);
		$result->bindParam(':id', $id, PDO::PARAM_INT);
		$result->execute();
		$task = $result->fetch();
		return $task;
	}
}
?>