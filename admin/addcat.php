<?php
	$data = $_POST;

	require 'adminfunctions.php';

	$admin = isAdmin($data["login"], $data["password"]);

	if ($admin != false) {

		$cat = R::dispense('category');

		$cat->name = $data['name'];
		$cat->image = "empty.jpg";
		 
		R::store($cat);

		echo json_encode("Успешно!".$cat->id);
	}
	else 
	{
		echo json_encode("Ошибка!");
		exit();
	}
?>