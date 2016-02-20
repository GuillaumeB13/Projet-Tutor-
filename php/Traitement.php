<!DOCTYPE html>
<?php
	include_once 'config.php';
	session_start();
?>
<html>
	<head>
		<meta charset='UTF_8'>
		<title> Traitement </title>
		<link rel="stylesheet" href="Traitement.css"/>
	</head>
	<body>
			<div class="titre1"><h2>Fenetre d'aperçu du scan</h2></div>

			<h2>Paramétrage image</h2>

		<section3>
			<h3><center>Choix du type de document</center></h3>
			<div class="menu">
				<select name="select">
					<option value="value1">Type du document à envoyer</option> 
					<option value="value2">Carte Nationnale D'Identité</option>
					<option value="value3">Dans la prochaine version ...</option>
				</select>
			</div>
		</section3><br>

		<form method="post">
			<input type="submit" name="OCR" value="Lancer le traitement ?" />
		</form>
	</body>
</html>

<?php
	if(isset($_POST['OCR']))
	{
		exec('/var/www/html/OCR/php/script.sh');
		header('Location: /OCR/php/Finalisation.php');
	}
?>