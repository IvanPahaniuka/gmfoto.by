<?php

	$data = $_POST;

	if (isset($data['login']) == false || isset($data['password']) == false ||
		$data['login'] == "" || $data['password'] == "") {
		header ('Location: auth.php');
		exit();
	}

	function go_auth($login, $password) {

		$line = '
		<form id="formPost" action="auth.php" method="post">
			<input type="hidden" name="errors">
			<input type="hidden" name="login" value="'.$login.'">
			<input type="hidden" name="password" value="'.$password.'">
		</form>
		<script type="text/javascript">
			document.getElementById("formPost").submit();
		</script>';

		echo $line;

		exit();
	}

	require 'adminfunctions.php';


	$admin = isAdmin($data['login'], $data['password']);

	if ($admin == false) {
		go_auth($data['login'], $data['password']);
	}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Меню администратора</title>
	<link rel="stylesheet" type="text/css" href="style.css">
	<script type="text/javascript" src="../scripts/jQuery.js"></script>
</head>
<body>
	<h1>Разделы базы данных</h1>
	<label class="labelr"><input class="mainradio admin" type="radio" name="dbitem"><br>Администратор</label>
	<label class="labelr"><input class="mainradio category" type="radio" name="dbitem"><br>Категории</label>
	<label class="labelr"><input class="mainradio foto" type="radio" name="dbitem"><br>Фотографии</label>
	<br><br>
	<div class="radioblock admin">
		<form class="ajaxform" method="post" action="changeadmin.php">
			<h3>Изменение логина/пароля админа</h3>
			<input class="login" type="hidden" name="login" value="<?=$data["login"]?>">
			<input class="password" type="hidden" name="password" value="<?=$data["password"]?>">
			<label>Логин: <input id="newlogin" type="text" name="newlogin" value="<?=$data["login"]?>"></label><br><br>
			<label>Пароль: <input id="newpassword" type="password" name="newpassword" value="<?=$data["password"]?>"></label><br><br>
			<label>Повтор пароля: <input id="newpassword2" type="password" name="newpassword2" value="<?=$data["password"]?>"></label><br><br>
			<p id="passwordErr" style="display: none; color: red;">Пароли не совпадают!</p>
			<button type="submit">Изменить</button>
		</form>
	</div>
	<div class="radioblock category">
		<label class="labelr"><input class="catradio add" type="radio" name="dbitem3"><br>Добавить</label>
		<label class="labelr"><input class="catradio change" type="radio" name="dbitem3"><br>Изменить</label>
		<label class="labelr"><input class="catradio delete" type="radio" name="dbitem3"><br>Удалить</label>

		<div class="catradioblock add">
			<form class="ajaxform" method="post" action="addcat.php">
				<h3>Добавление категории</h3>
				<input class="login" type="hidden" name="login" value="<?=$data["login"]?>">
				<input class="password" type="hidden" name="password" value="<?=$data["password"]?>">
				<label>Название: <input class="name" type="text" name="name"></label><br>
				<button type="submit">Добавить</button>
			</form>
		</div>

		<div class="catradioblock change">
			<form class="ajaxform" method="post" action="changecat.php">
				<h3>Изменение категории</h3>
				<input class="login" type="hidden" name="login" value="<?=$data["login"]?>">
				<input class="password" type="hidden" name="password" value="<?=$data["password"]?>">
				<select class="catselect withimg" name="category">
					<?
						$items = R::getAll("SELECT * FROM `category`");

						$selectedid = $items[1]["id"];
						for ($i=1; $i<count($items); $i++):
					?>
				  		<option data-image="<?=$items[$i]["image"]?>" value="<?=$items[$i]["id"]?>" <? if ($i == 1) echo "selected"; ?>><?=$items[$i]["name"]?></option>
				  	<? endfor; ?>
				</select><br>
				<label>Название: <input class="name" type="text" name="name"></label><br>
				<h4>Картинка</h4>
				<img class="imgshows"><br>
				<select class="imgselect" name="image">
					<option style="display: none"></option>
					<?
						$items = R::getAll("SELECT id,id_category,image,name FROM `image`");


						for ($i=0; $i<count($items); $i++):
					?>
				  		<option data-image="<?=$items[$i]["image"]?>" data-idcategory="<?=$items[$i]["id_category"]?>" value="<?=$items[$i]["id"]?>" ><?=$items[$i]["name"]?></option>
				  	<? endfor; ?>
				</select><br>
				<button type="submit">Изменить</button>
			</form>
		</div>

		<div class="catradioblock delete">
			<form class="ajaxform" method="post" action="deletecat.php">
				<h3>Удаление категории</h3>
				<input class="login" type="hidden" name="login" value="<?=$data["login"]?>">
				<input class="password" type="hidden" name="password" value="<?=$data["password"]?>">
				<select class="catselect" name="category">
					<?
						$items = R::getAll("SELECT id,name FROM `category`");


						for ($i=1; $i<count($items); $i++):
					?>
				  		<option value="<?=$items[$i]["id"]?>" <? if ($i == 1) echo "selected"; ?>><?=$items[$i]["name"]?></option>
				  	<? endfor; ?>
				</select><br>
				<button type="submit">Удалить</button>
			</form>
		</div>
	</div>
	<div  class="radioblock foto">
		<label class="labelr"><input class="fotoradio add" type="radio" name="dbitem2"><br>Добавить</label>
		<label class="labelr"><input class="fotoradio change" type="radio" name="dbitem2"><br>Изменить</label>
		<label class="labelr"><input class="fotoradio delete" type="radio" name="dbitem2"><br>Удалить</label>

		<div class="fotoradioblock add">
			<form class="ajaxform" method="post" action="addfoto.php">
				<h3>Добавление фото</h3>
				<h4>Категория</h4>
				<input class="login" type="hidden" name="login" value="<?=$data["login"]?>">
				<input class="password" type="hidden" name="password" value="<?=$data["password"]?>">
				<select class="catselect" name="category">
					<?
						$items = R::getAll("SELECT id,name FROM `category`");


						for ($i=1; $i<count($items); $i++):
					?>
				  		<option value="<?=$items[$i]["id"]?>" <? if ($i == 1) echo "selected"; ?>><?=$items[$i]["name"]?></option>
				  	<? endfor; ?>
				</select><br>
				<label>Название: <input class="name" type="text" name="name"></label><br><br>
				<label>Изображение: <input class="imgfile" type="file" name="fileimg" accept="image/x-png,image/gif,image/jpeg" /></label><br>
				<img class="imgshow"><br><br>
				<button type="submit">Добавить</button>
			</form>
		</div>

		<div class="fotoradioblock change">
			<form class="ajaxform" method="post" action="changefoto.php">
				<h3>Изменение фото</h3>
				<h4>Категория</h4>
				<input class="login" type="hidden" name="login" value="<?=$data["login"]?>">
				<input class="password" type="hidden" name="password" value="<?=$data["password"]?>">
				<select class="catselect withimg" name="category">
					<?
						$items = R::getAll("SELECT id,name FROM `category`");


						for ($i=1; $i<count($items); $i++):
					?>
				  		<option value="<?=$items[$i]["id"]?>" <? if ($i == 1) echo "selected"; ?>><?=$items[$i]["name"]?></option>
				  	<? endfor; ?>
				</select><br>
				<select class="imgselect" name="image">
					<option style="display: none"></option>
					<?
						$items = R::getAll("SELECT id,id_category,image,name FROM `image`");


						for ($i=0; $i<count($items); $i++):
					?>
				  		<option data-image="<?=$items[$i]["image"]?>" data-idcategory="<?=$items[$i]["id_category"]?>" value="<?=$items[$i]["id"]?>"><?=$items[$i]["name"]?></option>
				  	<? endfor; ?>
				</select><br>
				<img class="imgshows"><br><br>
				<label>Название: <input class="name" type="text" name="name"></label><br><br>
				<label>Изображение: <input class="imgfile" type="file" name="fileimg" accept="image/x-png,image/gif,image/jpeg" /></label><br>
				<button type="submit">Изменить</button>
			</form>
		</div>

		<div class="fotoradioblock delete">
			<form class="ajaxform" method="post" action="deletefoto.php">
				<h3>Удаление фото</h3>
				<h4>Категория</h4>
				<input class="login" type="hidden" name="login" value="<?=$data["login"]?>">
				<input class="password" type="hidden" name="password" value="<?=$data["password"]?>">
				<select class="catselect withimg" name="category">
					<?
						$items = R::getAll("SELECT id,name FROM `category`");


						for ($i=1; $i<count($items); $i++):
					?>
				  		<option value="<?=$items[$i]["id"]?>" <? if ($i == 1) echo "selected"; ?>><?=$items[$i]["name"]?></option>
				  	<? endfor; ?>
				</select><br>
				<select class="imgselect" name="image">
					<option style="display: none"></option>
					<?
						$items = R::getAll("SELECT id,id_category,image,name FROM `image`");


						for ($i=0; $i<count($items); $i++):
					?>
				  		<option data-image="<?=$items[$i]["image"]?>" data-idcategory="<?=$items[$i]["id_category"]?>" value="<?=$items[$i]["id"]?>"><?=$items[$i]["name"]?></option>
				  	<? endfor; ?>
				</select><br>
				<img class="imgshows"><br><br>
				<button type="submit">Удалить</button>
			</form>
		</div>
	</div>
	<script type="text/javascript" src="script.js"></script>
</body>
</html>