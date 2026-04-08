<?php
session_start();

if ($_GET['login'] != '' && $_GET['password'] != '' && md5($_GET['capcha']) == $_SESSION['randomnr2'])
{
	setcookie("login", $_GET['login'], time() + 3600);	
	setcookie("password", $_GET['password'], time() + 3600);
	include ("connect.php");
	$result = mysqli_query($link, 'INSERT INTO `users`(`login`, `password`) VALUES ("'.$_GET['login'].'","'.md5(md5($_GET['password'])).'")');
	header("Location: login.php");
}
include ("connect.php");
$categories = array();
if ($result = mysqli_query($link, 'SELECT * FROM categories')) {
    while($tmp = $result->fetch_assoc()) {
        $categories[] = $tmp;
    }
    $result->close();
}
 
$news = array();
$cat = isset($_REQUEST['cat']) ? (int) $_REQUEST['cat'] : 0;
$sql = "SELECT title, text, DATE_FORMAT(date, '%d.%m.%Y') AS date FROM news";
if ($result = mysqli_query($link, $sql)) {
    while($tmp = $result->fetch_assoc()) {
        $news[] = $tmp;
    }
    $result->close();
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
	
	<script src="/js/script.js"></script>
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
					<h1 class="title-page">Регистрация</h1>
					<div class="main">
                    <form class="field">
						<?php 
							if ($_COOKIE['login'])
							{
								echo "Здравствуйте, ".$_COOKIE['login']."!";
							}
							else
							{
						?>
						<p class='title-page'><label>Введите логин</label><input type="text" name="login" required></p>
						<p class='title-page'><label>Введите пароль</label><input type="password" name="password" required></p>
						<p>
						
						<img src="captcha.php" />
						</p><p class='title-page'><label>Код с картинки</label>
						<input type="text" name="capcha" required/>
						</p>
						<input type=submit name="action" value="Регистрация">
						<?php } ?>
					</form>
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