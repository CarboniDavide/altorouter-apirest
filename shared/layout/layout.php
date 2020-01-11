<!DOCTYPE html>
<html lang="en">

	<head>
		<meta charset="UTF-8">
		<title>Home Catalogue</title>
		<!-- Stylesheets -->
		<link type="text/css" rel="Stylesheet" href="../static/css/bootstrap.min.css" />
		<link type="text/css" rel="Stylesheet" href="../static/css/main.css" />

		<!-- load jquery -->
		<script src="../static/js/jquery3.4.1.min.js" type="text/javascript"></script>
		<!-- load bootstrap -->
		<script src="../static/js/bootstrap.min.js" type="text/javascript"></script>

	</head>
 
	<body> 

		<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/shared/layout/header.php'; ?>	

		<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/views/'.$page.'.php'; ?>	

		<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/shared/layout/footer.php'; ?>	
					
	</body> 

</html>









