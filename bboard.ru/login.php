<?php
$no_user = false;
$error = false;
include ("connect.php");						
if ($_GET['login'] && $_GET['password'])
{
	$login = $_GET['login'];
	$password = md5(md5($_GET['password']));
	$query = "SELECT `password`,`id` FROM `users` WHERE `login`='$login'";
	$result = mysqli_query($link, $query) or die('Запрос не удался: ' . mysql_error());
	if (mysqli_num_rows($result) == 0) {
		$no_user = true;
	}
	else
	{
		$line = mysqli_fetch_array($result);
		if ($password == $line[0]) {
			setcookie("login", $login, time() + 3600);
			setcookie("id", $line[1], time() + 3600);
			header("Location: index.php");
		} else
			$error = true;
	}
}
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
					<h1 class="title-page">Вход</h1>
					<?php
						if ($no_user) {
							?>
							<p class='title-page'>Нет такого пользователя!</p>
						<?php
						}
						if ($error) {
							?>
							<p class='title-page'>Неправильный пароль!</p>
						<?php
						}
						if (!$_COOKIE['login'])
						{
					?>
					<div class="main">
                    <form class="field">
						<p class='title-page'><label>Введите логин</label><input type="text" name="login" required></p>
						<p class='title-page'><label>Введите пароль</label><input type="password" name="password" required></p>
						<input type=submit value="Войти">
						<input type=button onclick="location.href = 'register.php';" value="Регистрация">
					</form>
					<?php
						}
						else
						{
							echo "<h1 class='title-page'>Здравствуйте, ".$_COOKIE['login']."!</h1>";
							echo "<div><form action=mail.php><input type=submit class='btn btn-primary' name='action' value='Написать нам'></form>";
							echo "<form action=logout.php><input type=submit class='btn btn-danger' name='action' value='Выход'></form></div>";
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