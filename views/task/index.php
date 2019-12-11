<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Задачи</title>
	<link rel="stylesheet" type="text/css" href="/misc/css/bootstrap.css">
	<style type="text/css">
		.th_sort {
			background-image: url(/misc/img/asc.jpg);
			background-repeat: no-repeat;
			background-size: cover;
			width:10px;
			height:10px;
			margin-left:10px;
		}
	</style>
</head>
<body>
	<div style="margin: 0 auto; display: block; width:90%;">
		<center><h2>Задачи</h2></center><br>
		<table class="table" style="table-layout: fixed;">
		  <thead>
			<tr>
			<?php /*Вывод шапки таблицы*/
			foreach ($taskList[0]['columns'] as $row => $value) {?>
				<th scope="col"><div style="float:left;"><a href="/tasks/<?php echo $taskList[0]['current_page'];?>/<?php echo $value;?>/<?php 
				if($value != $taskList[0]['sort'])
					echo 'asc';
				elseif ($value == $taskList[0]['sort'] and $taskList[0]['typesort'] == 'asc')
					echo 'desc';
				else echo 'asc';
				?>"><?php echo $row;?></a></div><div class="th_sort"></div></th>
			<?php
			}
			?>
			</tr>
			</thead>
			<tbody>
			<?php  /*Вывод тела таблицы*/
			foreach ($taskList as $taskItem) {?>
			  <tr <?php if ($taskItem['edit'] == 1) {?>style="background-color: #FFDEAD;"<?php } ?>>
				<th scope="row"><?php echo $taskItem['id'];?></th>
				<td><?php echo $taskItem['user'];?></td>
				<td><?php echo $taskItem['email'];?></td>
				<td><?php echo $taskItem['text'];?></td>
				<td><input type="checkbox" <?php if ($taskItem['status']== 1) { ?>checked <?php }?> disabled></input>
					<?php if (!User::isGuest()) 
					{ ?>       
						&nbsp;&nbsp;&nbsp;&nbsp;<a href="/edittask/edit/<?php echo $taskItem['id'];?>">Ред.</a>
					<?php 
					}
					?>
				</td>
			  </tr>
			<?php
			}
			?>
			</tbody>
		</table>
		<nav aria-label="Page navigation">
			<ul class="pagination">
			<?php for ($i=1; $i <= $taskList[0]['total_pages']; $i++) { ?>
				<li class="page-item"><a class="page-link" href="/tasks/<?php echo $i;?>/<?php echo $taskList[0]['sort'];?>/<?php echo $taskList[0]['typesort'];?>"><?php echo $i; ?></a></li>
			<?php } ?>	
			</ul>
		</nav>
		<p>
			<div style="width:20px;height:20px;background-color: #FFDEAD;border: 1px solid gray;float:left;"></div>&nbsp;&nbsp;- задачи, отредактированные администратором
		</p>

		<a class="btn btn-outline-primary" href="/newtask/create">Создать задачу</a>
		<?php if (User::isGuest()) 
		{ ?>       
				<a class="btn btn-outline-primary" href="/user/login">Авторизация</a>
			<?php 
		}	else { ?>
				<a class="btn btn-outline-primary" href="/user/logout">Выйти</a>
			<?php }
		?>
	</div>
</body>
</html>