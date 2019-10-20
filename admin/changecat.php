<?php
	$data = $_POST;

	require 'adminfunctions.php';

	$admin = isAdmin($data["login"], $data["password"]);

	if ($admin != false) {
		$cat = R::load('category', $data["category"]);
		$cat->name = $data['name'];

		if ($data['image'] == ""){
			R::store($cat);
			echo json_encode("Успешно!");
			exit();
		}

		$img = array_shift(array_shift(R::getAll('SELECT image FROM `image` WHERE `id` = ?',array($data['image']))));
		
		$cat->image = $img;
		R::store($cat);

		updateAllCatIMG();

		echo json_encode("Успешно!");
	}
	else 
	{
		echo json_encode("Ошибка!");
		exit();
	}
?>