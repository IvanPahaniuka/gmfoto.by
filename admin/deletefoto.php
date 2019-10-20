<?php
	$data = $_POST;

	require 'adminfunctions.php';

	$admin = isAdmin($data["login"], $data["password"]);

	if ($admin != false) {
		if ($data['image'] == "") {
			echo json_encode("Ошибка!");
			exit();
		}

		$foto = R::load('image',$data['image']);
		delete_foto($foto->image);
		$img = $foto->image;
		$id_c = $foto->id_category;
		delete_foto($foto->image_big);
		R::trash($foto);

		$cat = R::load('category',$id_c);
		if ($cat->image == $img) $cat->image = "empty.jpg";
		R::store($cat);

		echo json_encode("Успешно!");
		
	}
	else 
	{
		echo json_encode("Ошибка!");
		exit();
	}
?>