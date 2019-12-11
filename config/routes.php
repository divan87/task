<?php /**
 * Массив маршрутов
 */
return array(
	'tasks/([0-9]+)/([a-z]+)/([a-z]+)' => 'task/index/$1/$2/$3',  //$1 - page, $2 - sort_column, $3 - typesort

	'newtask/create' => 'task/create', //Создание задания

	'tasks' => 'task/index',  

	'edittask/edit/([0-9]+)' => 'task/edit/$1',  //Редактирование задания

	'user/login' => 'user/login',  //Авторизация пользователя
	'user/logout' => 'user/logout',

	'' => 'task/index'
	);
?>