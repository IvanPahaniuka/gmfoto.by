<?php

	$data = $_POST;

	require 'adminfunctions.php';

	$admin = isAdmin($data["login"], $data["password"]);

	if ($admin != false) {

		$foto = R::load('image',$data['image']);
		$foto->name = $data['name'];

		if ($_FILES['fileimg']['tmp_name'] != "") {

			$uploaddir = '../img/fotos/';
			$uploadfilename =  $data["category"] . '_' . $foto->id . '.' . getExtension($_FILES['fileimg']['name']);
			$newfilename = $data["category"] . '_' . $foto->id . 's.' . getExtension($_FILES['fileimg']['name']);

			delete_foto($foto->image);
			delete_foto($foto->image_big);

			if (move_uploaded_file($_FILES['fileimg']['tmp_name'], $uploaddir . $uploadfilename) == false) {
			    echo json_encode("Ошибка при загрузке файла!");
			    R::store($foto);

				exit();
			}

			$foto->image_big = $uploadfilename;

			createLowSizeIMG($uploaddir.$uploadfilename, $uploaddir.$newfilename);

			$foto->image = $newfilename;
			
		}

		R::store($foto);
		echo json_encode("Успешно!");
		
	}
	else 
	{
		echo json_encode("Ошибка!");
		exit();
	}

?>