<?php
	$link = mysqli_connect('localhost', 'root', '')
			or die('Не удалось соединиться: ' . mysqli_error($link));
	mysqli_select_db($link, 'board_db') or die(mysqli_error($link));
?>