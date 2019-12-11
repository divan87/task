<!DOCTYPE html>
<html>
<head>
	<title>Авторизация</title>
	<link rel="stylesheet" type="text/css" href="/misc/css/bootstrap.css">
</head>
<body>
	<div style="color: red; font-size: 14px; padding: 20px; margin: 0 auto; display: block; width:400px;">
		<?php if (isset($errors) && is_array($errors)): ?>
			<ul>
				<?php foreach ($errors as $error): ?>
					<li> - <?php echo $error; ?></li>
				<?php endforeach; ?>
			</ul>
		<?php endif; ?>
	</div>

	<?php if (User::isGuest()) 
	{ ?>       
		<form action="" method="post" class="form-login" style="display: block; width: 400px; margin: 0 auto;  padding: 20px; text-align: center;">
			<center><h2>Авторизация</h2></center><br>
			<input type="text" name="login" placeholder="Логин" value="<?php echo $login; ?>"/><br><br><br>
			<input type="password" name="password" placeholder="Пароль" value="<?php echo $_POST['password']; ?>"/><br><br><br>
			<div class="os"></div>
			<input type="submit" name="submit" class="btn btn-outline-primary" style="width: 120px;" value="Вход" />
			<a class="btn btn-outline-primary" href="/tasks">Вернуться к списку задач</a>
			<div class="os"></div>
		</form>
		<?php 
	}	else { ?>
			<div style="display: block; width: 400px; margin: 0 auto; background: #f2f1f0; padding: 20px; color:#555; text-align: center;">
				<center><h2 style="color:#555;">Вы уже авторизированы </h2></center>
				<a class="btn btn-outline-primary" href="/tasks">Вернуться к списку задач</a>
			</div>
		<?php }
	?>
</body>
</html>
