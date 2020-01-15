<!DOCTYPE html>
<html lang="en">

	<head>
		<meta charset="UTF-8">
		<title>Home Catalogue</title>
		<!-- Stylesheets -->
		<link type="text/css" rel="Stylesheet" href="css/bootstrap.min.css" />
		<link type="text/css" rel="Stylesheet" href="css/main.css" />

		<!-- load jquery -->
		<script src="js/jquery3.4.1.min.js" type="text/javascript"></script>
		<!-- load bootstrap -->
		<script src="js/bootstrap.min.js" type="text/javascript"></script>

	</head>
 
	<body> 

		<?php include_once BASE_DIR . '/views/layout/header.php'; ?>	

		<?php include_once BASE_DIR . '/views/'.$page.'.php'; ?>	

		<?php include_once BASE_DIR . '/views/layout/footer.php'; ?>	
					
	</body> 

</html>









