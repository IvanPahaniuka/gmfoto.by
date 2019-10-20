<?php

	$data = $_POST;

	require 'adminfunctions.php';

	$admin = isAdmin($data["login"], $data["password"]);

	if ($admin != false) {
		$cat = R::load('category', $data["category"]);
		
		R::trash($cat);

		$img = R::getAll('SELECT * FROM `image` WHERE `id_category` = ?', array($data["category"]));
		foreach ($img as $img0) {
			delete_foto($img0["image_big"]);
			delete_foto($img0["image"]);
		}

		R::exec('DELETE FROM `image` WHERE `id_category` = ?', array($data["category"]) );

		R::exec('ALTER TABLE `category` AUTO_INCREMENT=0');

		$max_id = array_shift(array_shift(R::getAll('SELECT MAX(`id`) FROM `image`')));
		if ($max_id != null) R::exec('ALTER TABLE `image` AUTO_INCREMENT='.$max_id);

		updateAllCatIMG();

		echo json_encode("Успешно!");
	}
	else 
	{
		echo json_encode("Ошибка!");
		exit();
	}
?>