<?php
	require '../php/db.php';
	include('classSimpleImage.php');

	function isAdmin($login, $password) {

		$admin = R::findOne('admin', 'login = ?', array($login));

		if ($admin) {
			if (!password_verify($password, $admin->password)) {
				return false;
			}

			return $admin;
		}
		else 
		{
			return false;
		}
	}


	function isFoto_exists($url) {
		$url = "//gmfoto.by/img/fotos/" . $url;
		$Headers = @get_headers($url);

		if(strpos('200', $Headers[0])) {
			return true;
		} else {
			return false;
		}
	}

	function delete_foto($url) {
		if ($url != "") 
			if (file_exists($_SERVER['DOCUMENT_ROOT'].'/img/fotos/'.$url))
				@unlink("../img/fotos/".$url);
	}

	function createLowSizeIMG($file, $newfile) {
		$image = new SimpleImage();
   		$image->load($file);

   		$width = $image->getWidth();
   		$height = $image->getHeight();
   		if ($width > $height) {
   			$image->resizeSimple(floor(($width-$height) / 2),0,$height, $height);
   		} else $image->resizeSimple(0,floor(($height-$width) / 2),$width, $width);
   		if ($image->getWidth() > 540) $image->resizeToWidth(540);
   		
   		$image->save($newfile);
	}

	function getExtension($filename) {
    	return end(explode(".", $filename));
  	}

  	function updateAllCatIMG($isAddFunct = false) {

  		$arr = R::getAll("SELECT * FROM `category`");

  		if (count($arr) <= 1) return;
  		if ($isAddFunct) if (sqrt(count($arr)-1) - floor(sqrt(count($arr)-1)) > 0.0001) return;

		$img = new SimpleImage();
		$fimage = new SimpleImage();

  		$a = floor(sqrt(count($arr)-1));
  		if ($a > 4) $a = 4;
  		$i = 1; 
  		$width = floor(540 / $a);
  		$fimage->create($width*$a, $width*$a);


  		for ($y = 0; $y < $a; $y++)
  			for ($x = 0; $x < $a; $x++) {
  				$img->load('../img/fotos/'.$arr[$i]['image']);
  				
  				$fimage->addIMG($width * $x, $width * $y, $width, $width, $img);

  				$i++;
  			}

  		$fimage->save("../img/fotos/main1.jpg");
  	}

?>