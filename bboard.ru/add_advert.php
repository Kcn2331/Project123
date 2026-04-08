<?php
$no_user = false;
$error = false;
include ("connect.php");						
if (isset($_POST['ob_name']))
{
	$filename = $_FILES["uploadfile"]["name"];
    $tempname = $_FILES["uploadfile"]["tmp_name"];
	$ob_name = $_POST['ob_name'];
	$ob_price = $_POST['ob_price'];
	$ob_cat = $_POST['ob_cat'];
	$ob_descript = $_POST['ob_descript'];
    $folder = "./images/" . $filename;

	if (is_numeric($ob_cat))
	{
		// Now let's move the uploaded image into the folder: image
		if (move_uploaded_file($tempname, $folder)) 
		{
			$sql = "INSERT INTO `products` (`title`,`intro`,`img`,`price`) VALUES ('$ob_name','$ob_descript','$filename',$ob_price)";
	
			// Execute query
			mysqli_query($link, $sql);
	
			$id = mysqli_insert_id($link);
			$sql = "INSERT INTO `categories_products` (`id_product`,`id_category`) VALUES ($id,$ob_cat)";
			mysqli_query($link, $sql);
			echo "<h3>&nbsp; Объявление успешно добавлено.</h3>";
		} 
		else 
		{
			echo "<h3>&nbsp; Failed to upload image!</h3>";
		}
	}
	else
		echo "<h3>&nbsp; Категория не выбрана!</h3>";
}
?><!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Доска объявлений</title>
    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="css/shop-homepage.css" rel="stylesheet">
	
	<script src="js/script.js"></script>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
    <!-- Navigation -->
<nav class="nav">
  <a class="a" href="index.php">Главная</a>
  <a class="a" href="news.php">Новости</a>
  <a class="a" href="cart.php">Избранное</a>
  <a class="a" href="login.php">Личный кабинет</a>
  <div class="animation start-home"></div>
</nav>
 
    <!-- Page Content -->
    <div class="container">
 
        <div class="row">
 
            <div class="col-md-3">
            </div>
 
            <div class="col-md-9">
                <div class="row row-reviews">
					<h1 class="title-page">Добавление объявления</h1>
					<?php
						if ($_COOKIE['login'])
						{
					?>
					<div class="main">
                    <form class="field" method="POST" action="" enctype="multipart/form-data">
                        <div class="form-group">
							<select name="ob_cat" class="form-control form-control-lg" required>
							<option selected>Выберите категорию</option>
							<?php
								$sql = "SELECT * FROM `categories`";
								$res = mysqli_query($link, $sql);
								while ($row = mysqli_fetch_array($res))
								{
									echo "<option value=".$row['id'].">".$row['title']."</option>";									
								}
							?>
							</select>
                        </div>   
						<p class='title-page'><label>Введите название</label><input type="text" name="ob_name" required></p>
						<p class='title-page'><label>Введите описание</label><input type="text" name="ob_descript" required></p>
						<p class='title-page'><label>Введите стоимость</label><input type="text" name="ob_price" required></p>
						<div class="form-group">
							<input class="form-control" type="file" name="uploadfile" value="" />
						</div>
						<input type=submit value="Добавить">
					</form>
					<?php
						}
					?>
					</div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.container -->
    <div class="container">
        <hr>
        <!-- Footer -->
	<div class="footer">
		<div class="siteContent" style="padding-top:10px;">

			<div style="width:42%; float:left; margin-left: 15px;">
				<span style="font-size:150%;">bboard.ru&copy<?php echo date('Y'); ?></span>
				<br>
			</div>
			
			<div style="width:22%; float:left; margin-left: 10px;">
				<span class="glyphicon glyphicon-envelope"></span>&nbsp;&nbsp;<a href="mailto:help@bboard.ru?Subject=Question" target="_top">help@bboard.ru</a><br>
				<span class="glyphicon glyphicon-phone-alt"></span>&nbsp;&nbsp;США&nbsp;&nbsp;&nbsp;&nbsp;+1-234-567-89-00<br>
				<span class="glyphicon glyphicon-phone-alt"></span>&nbsp;&nbsp;Валикобритания&nbsp;&nbsp;&nbsp;&nbsp;+44-780-076-76-90
			</div>
			
			<div style="width:22%; float:left; margin-left: 10px;">
				<br>
				<span class="glyphicon glyphicon-phone-alt"></span>&nbsp;&nbsp;Москва&nbsp;&nbsp;&nbsp;&nbsp;+7(495)111-22-33<br>
				<span class="glyphicon glyphicon-phone-alt"></span>&nbsp;&nbsp;Санкт-Петербург&nbsp;&nbsp;&nbsp;&nbsp;+7(812)454-57-75
			</div>
		</div>
	</div>
    </div>
    <!-- /.container -->
    <!-- jQuery -->
    <script src="js/jquery.js"></script>
</body>
</html>