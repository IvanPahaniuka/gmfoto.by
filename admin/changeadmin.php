<?php
	
	$data = $_POST;
	
	if ($data["newpassword"] != $data["newpassword2"]) {
		echo json_encode("Пароли не совпадают!");
		exit();
	}


	require 'adminfunctions.php';

	$admin = isAdmin($data["login"], $data["password"]);

	if ($admin != false) {
		$admin->login = $data["newlogin"]; 
		$admin->password = password_hash($data["newpassword"], PASSWORD_DEFAULT); 
		R::store($admin);

		echo json_encode("Успешно!");
	}
	else 
	{
		echo json_encode("Ошибка!");
		exit();
	}
?>