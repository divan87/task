<!DOCTYPE html>
<html>
<head>
	<title>Редкатирование задачи</title>
	<link rel="stylesheet" type="text/css" href="/misc/css/bootstrap.css">
</head>
<body>
	<div style="color: red; font-size: 14px; padding: 20px; margin: 0 auto; display: block; width:400px;">
		<?php if (isset($errors) && is_array($errors)){?>
			<ul>
				<?php foreach ($errors as $error): ?>
					<li> - <?php echo $error; ?></li>
				<?php endforeach; ?>
			</ul>
		<?php } elseif ($success == true){echo 'Задача успешно отредактирована.';}?>
	</div>

	<form action="" method="post" style="display: block; width: 400px; margin: 0 auto;  padding: 20px; text-align: center;">
		<center><h2>Редактирование задачи</h2></center><br>
		<input type="hidden" name="task_id" value="<?php echo $task['id']; ?>"></input>
		<input placeholder="Пользователь" type="text" name="user" readonly value="<?php echo $task['user']; ?>"></input><br><br>
		<input placeholder="E-Mail" type="text" name="email" readonly value="<?php echo $task['email']; ?>"></input><br><br>
		<textarea cols="50" rows="5" placeholder="Текст" name="text"><?php echo $task['text']; ?></textarea><br><br>
		<label>Выполнена:&nbsp;</label><input name="status" type="checkbox" <?php if ($task['status']== 1) { ?>checked <?php }?> ></input><br><br>
  		<?php if (User::isGuest()) 
		{ ?>       
			<a class="btn btn-outline-primary" href="/user/login">Авторизация</a>
			<?php 
		}	else { ?>
			<input type="submit" class="btn btn-outline-primary" name="ok" value = "Редактировать"></input>
			<?php }
		?>	
		<a class="btn btn-outline-primary" href="/tasks">Вернуться к списку задач</a>
	</form>
</body>
</html>
