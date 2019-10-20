<?php

function get_categories() {

	return R::getAll("SELECT * FROM `category`");

}

function get_fotos($id_category) {

	if ($id_category == 1) return R::getAll("SELECT * FROM `image` ORDER BY `id` DESC");

	return R::getAll('SELECT * FROM `image` WHERE `id_category` = ? ORDER BY `id` DESC', array($id_category));

}

function go_main() {
	echo '<script>document.location.replace("//gmfoto.by");</script>';
}

?>