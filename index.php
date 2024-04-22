<?php

include("mysql.php");

session_start();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<title>Adriano's</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<link href="_stylesheet.css" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
	<script src="pizza.js"></script>
</head>
<body>
	<div class="holder">
		<div class="top"></div>

		<div class="navi">
			&nbsp;
		</div>

		<div class="pad">
			<?php
			// include php file
			if (empty($_GET['site'])) {
				include("category.php");
			} else {
				include($_GET['site'].".php");
			}
			?>
		</div>

		<div class="basket"><?php include("basket.php")?></div>

		<div class="footer"></div>
	</div>
</div>
</body>
</html>