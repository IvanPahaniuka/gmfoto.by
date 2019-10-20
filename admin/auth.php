<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Вход в меню администратора</title>
</head>
<body>
	<form action="index.php" method="post">
		<?php
			$data = $_POST;

			if (isset($data['errors'])) {
				echo '<h2 style="color:red">Логин или пароль введены неверно!</h2>';
			}
		?>
		<h1>Вход в меню администратора</h1>
		<label>Логин: <input type="text" name="login" value="<?=$data['login']?>"></label><br><br>
		<label>Пароль: <input type="password" name="password" value="<?=$data['password']?>"></label><br><br>
		<button type="submit" name="enter">Войти</button>
	</form>
</body>
</html>