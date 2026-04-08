<?php

	$action = $_POST['action'];
	switch ($action) {
		case 'add_to_cart':
			add_to_cart();
			break;
		case 'delete_from_cart':
			delete_from_cart();
			break;
		default:
			break;
	}
	
	function add_to_cart() {
		include ("connect.php");
		$id = $_POST['id'];
		$count = $_POST['count'];
		$user = $_COOKIE['id'];
		$sql = "SELECT count FROM cart WHERE product = $id AND user_id = $user";
		$current_count = 0;
		if ($result = mysqli_query($link, $sql)) {
			$tmp = $result->fetch_assoc();
			$current_count = $tmp['count'];
			$result->close();
		}
		if ($current_count == 0) 
			$query = "INSERT INTO cart(product, count, user_id) VALUES ($id, $count, $user)";
		else {
			$count = $current_count + $count;
			$query = "UPDATE cart SET count = $count WHERE product = $id";
		}
		$res = mysqli_query($link, $query);
	};
	function delete_from_cart() {
		include ("connect.php");
		$id = $_POST['id'];
		$count = $_POST['count'];
		$sql = "SELECT count FROM cart WHERE id = $id";
		if ($result = mysqli_query($link, $sql)) {
			$tmp = $result->fetch_assoc();
			$current_count = $tmp['count'];
			$result->close();
		}
		if ($current_count <= $count) 
			$query = "DELETE FROM cart WHERE id = $id";
		else {
			$count = $current_count - $count;
			$query = "UPDATE cart SET count = $count WHERE id = $id";
		}
		$res = mysqli_query($link, $query);
	};
	
	function add_review() {
		include ("connect.php");
		$product = $_POST['id'];
		$note = $_POST['note'];
		$review = $_POST['text'];
		$query = "INSERT INTO reviews(note, review, product) VALUES ($note, '$review', $product)";
		$res = mysqli_query($link, $query);
		$query = "UPDATE products SET reviews_count = reviews_count + 1 WHERE `id`=$product";
		$res = mysqli_query($link, $query);
	};
?>
