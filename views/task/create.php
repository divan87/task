<!DOCTYPE html>
<html>
<head>
	<title>Создание задачи</title>
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
		<?php } elseif ($success == true){echo 'Задача успешно создана.';}?>
	</div>

	<form action="" method="post" style="display: block; width: 400px; margin: 0 auto;  padding: 20px; text-align: center;">
		<center><h2>Создание задачи</h2></center><br>
		<input placeholder="Пользователь" type="text" name="user" value="<?php echo $user; ?>"></input><br><br>
		<input placeholder="E-Mail" type="text" name="email" value="<?php echo $email; ?>"></input><br><br>
		<textarea cols="50" rows="5" placeholder="Текст" name="text"><?php echo $text; ?></textarea><br><br>
		<input type="submit" class="btn btn-outline-primary" name="ok" value = "Создать задачу"></input>
		<a class="btn btn-outline-primary" href="/tasks">Вернуться к списку задач</a>
	</form>
</body>
</html>
