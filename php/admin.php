<?php
	include_once 'config.php';
	session_start();
?>
<?php
	if(isset($_SESSION['login']))
	{
		if(isset($_SESSION['admin']) && $_SESSION['admin']=="true")
		{
			echo "
			<html>
				<head>
				    <link rel=\"stylesheet\" href=\"https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css\" integrity=\"sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7\" crossorigin=\"anonymous\">
					<meta charset='UTF-8'>
					<title>Administrateur</title>
					<center><strong><big><big><big>Zone Administrateur</big></big></big></strong></center>
				</head>
				<body>
				
				</body>
			</html>";
		}
		else
			echo "
			<html>
				<head>
					<meta charset='UTF-8'>
					<title>Zone Administrateur</title>
					<p> ERREUR !!!! Vous n'avez pas les droits suffisant pour accéder à cette page !! </p>
					<a href=\"/OCR/php/Traitement.php\">Retour à la page de traitement.</a> <br><br>
					<a href=\"/OCR/php/Ientification.php\">Re-connexion ?</a>

				</head>
				<body>
				
				</body>
			</html>";
	}

?>