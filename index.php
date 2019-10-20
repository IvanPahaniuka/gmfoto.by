<?php
	require 'php/db.php';

	require_once 'php/functions.php';
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
	<title>Фотограф Вячеслав Толстоногов: Гомель</title>
	<script type="text/javascript" src="scripts/jQuery.js"></script>
	<link rel="stylesheet" type="text/css" href="css/main.css">
	<link rel="stylesheet" type="text/css" href="css/socials.css">
	<link rel="stylesheet" type="text/css" href="css/header.css">
	<link rel="stylesheet" type="text/css" href="css/footer.css">
</head>
<body>
	<header class="normal">
    	<h1><a href="//gmfoto.by">GMFOTO.BY</a></h1>
    	<nav><input id="more" type="checkbox"><label for="more" class="disable"><img class="open" src="img/buttons/more.svg"><img class="close" src="img/buttons/close.svg"></label><span><a href="//gmfoto.by">Главная</a><a href="#">Блог</a><a href="#">Обо&nbspмне</a><span></nav>
	</header>
	<script type="text/javascript" src="scripts/header.js"></script>

	<div class="main">
		<?
			$isBadGET = false;

			if (!is_numeric($_GET['category']) || !isset($_GET['category'])) $isBadGET = true;
			if (isset($_GET['category']) && !is_numeric($_GET['category'])) {
				go_main();
				exit();
			}

			if(!$isBadGET){
				$items = get_fotos($_GET['category']);
			}
			else
			{
				$items = get_categories();
			}

			if (count($items) == 0) { 
				$cat = R::getAll("SELECT * FROM `category` WHERE `id` = " . $_GET['category']);

				if (count($cat) == 0) {
					go_main();
					exit();
				}
				else
				{
				echo "<h1>Мы приносим свои извинения, но в данный момент страница недоступна. Ведутся технические работы. Пожалуйста, зайдите позже.</h1>";
				}
			}

			foreach($items as $item):
	  ?><a class="item" style="background: url(img/fotos/<?=$item["image"]?>) no-repeat 50% 50%; background-size: cover;" <?
	  if ($isBadGET) {
	  	echo "href=\"//gmfoto.by/index.php?category=".$item["id"]."\"";
	  } ?>>
			<table class="whiteback"><tr><td class="vert-middle"><span><?=$item["name"]?></span></td></tr></table>
		</a><!--
	 --><?php endforeach; ?>
	</div>
	<script type="text/javascript" src="scripts/main.js"></script>

	<footer>
		<div class="socials">
			<div class="text">Ищи меня в социальных сетях</div>
			<div class="icons"><a href="https://www.instagram.com/slava_gomel_tlst/" target="_blank" class="in"><div></div></a><a href="https://vk.com/id219251041" target="_blank" class="vk"><div></div></a></div>
		</div>
	</footer>
	<div id="imgloader" style="display: none"></div>
</body>
</html>