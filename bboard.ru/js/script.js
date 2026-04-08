function add_to_cart(id) {
	var count = 1;
	$.ajax({
		url: "actions.php",
		type: "POST",
		data: {
			action: 'add_to_cart',
			id: id,
			count: count
		},
		success: function(msg){
			if (msg == "") {
				alert("Вещь устпешно добавлена в избранное.");
				location.href = "/cart.php";
			} else	
				alert("Что-то пошло не так!" + msg);
		}
	});
}
function delete_from_cart(id) {
	var count = 1;
	if (!confirm('Удалить вещь из избранного?'))
		return;
	$.ajax({
		url: "actions.php",
		type: "POST",
		data: {
			action: 'delete_from_cart',
			id: id,
			count: count
		},
		success: function(msg){
			if (msg == "") {
				alert("Вещь устпешно удалена из избранного.");
				location.href = "/cart.php";
			} else	
				alert("Что-то пошло не так!" + msg);
		}
	});
}