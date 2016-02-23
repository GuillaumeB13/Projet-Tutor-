<?php
	include_once 'config.php';
	session_start();
?>
<?php
	if(isset($_SESSION['login']) && isset($_SESSION['admin']) && $_SESSION['admin']=="true")
	{
		echo "
		<html>
			<head>
			    <link rel=\"stylesheet\" href=\"https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css\" integrity=\"sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7\" crossorigin=\"anonymous\">
				<meta charset='UTF-8'>
				<title>Administrateur</title>
				<h1>Zone Administrateur</h1>
			</head>
			<body>
			
			</body>
		</html>";
	}
	echo " <html>
			<head>
				<meta charset='UTF-8'>
			    <title>Traitement</title>
				<link rel=\"stylesheet\" href=\"https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css\" integrity=\"sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7\" crossorigin=\"anonymous\">
			</head>
			<body class=\"backbody\">
				<div class=\"row\">
					<p class=\"alert\"> Connectez vous pour avoir accés à cette partie du site. </p>
				<div class=\"row\">
				<div class=\"row\">
					<a href="."/OCR/php/Identification.php"." class=\"col-sm-offset-1\"> Se connecter !</a>
				<div class=\"row\">
			</body>
		</html>
		<style type=\"text/css\">
		.backbody
		{
			background-color: #D8D8D8;
		}
		.alert
		{
			color: red;
		}
		</style>";

?>