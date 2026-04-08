<?php
include ("connect.php");
 
$categories = array();
if ($result = mysqli_query($link, 'SELECT * FROM categories')) {
    while($tmp = $result->fetch_assoc()) {
        $categories[] = $tmp;
    }
    $result->close();
}
 
$carts = array();
$sql = 'SELECT ca.id AS cart_id, ca.user_id AS user, ca.count AS count, p.* FROM cart AS ca INNER JOIN products AS p ON p.id=ca.product WHERE ca.user_id='.$_COOKIE['id'];
if ($result = mysqli_query($link, $sql)) {
    while($tmp = $result->fetch_assoc()) {
        $carts[] = $tmp;
    }
    $result->close();
}
?>
<!DOCTYPE html>
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
					<h1 class="title-page">Заказ</h1>
                    <?php 
					if ($_COOKIE['login']) {
						if ($_GET['sum'] == 0)
							echo '<h2 class="title-page">Вы ещё ничего не заказали!</h2>';
						else
							echo '<h2 class="title-page">Ваш заказ на сумму '.$_GET['sum'].' руб. успешно оформлен</h2>';	
						foreach($carts AS $cart) {?>
						<div class="div-cart">
						<img src="images/<?php echo $cart['img'];?>" width=100 height=100 alt="">
                        <div>
                            <p><?php $sum += $cart['price']*$cart['count']; echo $cart['title'] . ' (' . $cart['count'] . $cart['unit'] . ' - ' . $cart['price']*$cart['count'] .'руб.)';?></p>
                        </div>
						
					</div>
                    <?php 
						}
						$user = $_COOKIE['id'];
						$sql = "DELETE FROM cart WHERE user_id = $user";
						mysqli_query($link, $sql);
						echo "<button onclick=location.href='index.php'>На главную</button>";
					} else echo "<h1 class='title-page'>Для просмотра необходимо войти!</h1>"?>
                </div>
            </div>
        </div>
    </div>
    <!-- /.container -->
    <div class="container">
        <br>
        <br>
        <br>
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