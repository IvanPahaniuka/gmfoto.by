<?php
	$data = $_POST;

	require 'adminfunctions.php';

	$admin = isAdmin($data["login"], $data["password"]);

	if ($admin != false) {


		if ($_FILES['fileimg']['tmp_name'] != "" && $data['name'] != "") {

			$foto = R::dispense('image');

			$foto->id_category = $data["category"];
			$foto->name = $data['name'];
			$foto->image = "";
			$foto->image_big = "";
			 
			R::store($foto);

			$uploaddir = '../img/fotos/';
			$uploadfilename =  $data["category"] . '_' . $foto->id . '.' . getExtension($_FILES['fileimg']['name']);

			if (move_uploaded_file($_FILES['fileimg']['tmp_name'], $uploaddir . $uploadfilename) == false) {
			    echo json_encode("Ошибка при загрузке файла!");
			    R::trash($foto);

			    $max_id = array_shift(array_shift(R::getAll('SELECT MAX(`id`) FROM `image`')));
				if ($max_id != null) R::exec('ALTER TABLE `image` AUTO_INCREMENT='.$max_id);

				exit();
			}

			$foto->image_big = $uploadfilename;

			$newfilename = $data["category"] . '_' . $foto->id . 's.' . getExtension($_FILES['fileimg']['name']);
			createLowSizeIMG($uploaddir.$uploadfilename, $uploaddir.$newfilename);

			$foto->image = $newfilename;

			R::store($foto);

			echo json_encode("Успешно!".$foto->id);
			
		}
		else {
			echo json_encode("Нет названия или/и файла!");
			exit();
		}
		
	}
	else 
	{
		echo json_encode("Ошибка!");
		exit();
	}
?>