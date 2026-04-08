<?php
include ("connect.php");
$categories = array();
if ($result = mysqli_query($link, 'SELECT * FROM categories')) {
    while($tmp = $result->fetch_assoc()) {
        $categories[] = $tmp;
    }
    $result->close();
}
 
$products = array();
$cat = isset($_REQUEST['cat']) ? (int) $_REQUEST['cat'] : 0;
$sql = 'SELECT p.* FROM products AS p ';
if ($cat) {
    $sql .= ' INNER JOIN categories_products AS cp ON cp.id_product=p.id AND cp.id_category=' . $cat;
}
if ($result = mysqli_query($link, $sql)) {
    while($tmp = $result->fetch_assoc()) {
        $products[] = $tmp;
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
                <p class="lead">Доска объявлений</p>
                <div class="list-group">
                    <?php
                    foreach($categories AS $category) {
                        echo ' <a href="?cat=' . $category['id'] . '" class="list-group-item">' . $category['title'] . '</a>';
                    }
                    echo ' <a class="list-group-item no-click"></a>';
                    echo ' <a href="add_advert.php" class="list-group-item"><center>Добавить объявление</center></a>';
                    ?>
                </div>
            </div>
			<?php
				if (isset($_GET['cat']))
				{
			?>
 
            <div class="col-md-9">
                <div class="row">
                    <?php foreach($products AS $product) {?>
                        <div class="col-sm-4 col-lg-4 col-md-4">
                            <div class="thumbnail">
                                <img src="images/<?php echo $product['img'];?>" alt="">
                                <div class="caption">
                                    
                                    <h4><?php echo $product['title'];?></h4>
                                    <p><?php echo $product['intro'];?></p>
									<?php if (isset($_COOKIE['login']) && $_COOKIE['login']) { ?>
									<button class="button-to-cart" onclick="add_to_cart(<?php echo $product['id'];?>)">В избранное</button>
									<?php } ?>
									<h4 class="pull-right"><?php echo $product['price'];?> руб.</h4>
                                </div>
                            </div>
                        </div>
 
                    <?php } ?>
                </div>
            </div>
			<?php 
				} else {
			?>
			            <div class="col-md-9">
                <div class="row">
					<h1 class="title-page"><center>ООО «Наши объявления»</center></h1>
					<h1></h1>
                </div>
            </div>
			<?php }?>
        </div>
    </div>
	<br>
	<br>
	<br>
    <!-- /.container -->
    <div class="container">
        <hr>
        <!-- Footer -->
	<div class="footer">
		<div class="siteContent" style="padding-top:10px;">

			<div style="width:42%; float:left; margin-left: 15px;">
				<span style="font-size:150%;">bboard.ru&copy2024.</span>
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
	
	<div class="modal fade" id="selectModal" tabindex="-1" role="dialog" aria-labelledby="Select Columns" aria-hidden="true"><div class="modal-dialog"><div class="modal-content"></div></div></div>
	<div class="modal fade" id="pdfmodal" tabindex="-1" role="dialog"><div class="modal-dialog"><div class="modal-content"></div></div></div>
	<div id="username" class="hidden"></div>
    </div>
    <!-- /.container -->
    <!-- jQuery -->
    <script src="js/jquery.js"></script>
</body>

</html>