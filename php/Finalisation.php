<!DOCTYPE html>
<?php
	ob_start();
	include_once 'config.php';
	session_start();
?>
<?php
	if (isset($_SESSION['login']))
	{
		list($width, $height) = getimagesize("img/ci.png"); 
		$width/=1.80;
		$height/=2;
		echo"
		<html>
			<head>
				<link rel=\"stylesheet\" href=\"https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css\" integrity=\"sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7\" crossorigin=\"anonymous\">
				<meta charset='UTF-8'>
				<link rel=\"stylesheet\" type=\"text/css\" href=\"style.css\">
			    <title>Finalisation</title>
			</head>
			<body class=\"container\" style=\"background-image:url(img/fond.jpg); overflow-x: hidden; background-size:cover;\">
				<div class=\"row\">
					<div class=\"col-sm-5 col-sm-offset-1\">
						<h1 class=\"titreh1\"> Résultat du document actuel </h1>
					</div>
					<div class=\"col-sm-4\">
						<form method=\"post\" class=\"col-sm-offset-10\">
							<input type="."submit"." value="."Déconnexion"." name=\"deco\" class=\"btn btn-warning\" style=\"margin-top:25px;\"/>
						</form>
					</div>
				</div>
				<br><br>
				<center>
					<br>
					<img src=\"/OCR/php/img/ci.png\" height=\"$height\" width=\"$width\" style=\"margin-right:100px\"/>
					<br><br>
					<h2 class=\"titre\">Aperçu des champs récupérés</h2>
				</center>
				<section>
					<form method="."post"." class=\"form-group\"><br><br>";
					include_once 'data.php';
					echo "
					<center>
						<h2 class=\"titre\">Enregistrer les données récupérées ?</h2>
					</center>

					<div class="."col-sm-offset-3".">
						<input type="."submit"." value="."Enregistrer les modifications"." name="."save"." class=\"btn btn-success\">
					</div>

				</form>
			</section>
			<section>
				<center><h2 class=\"titre\">Recommencer le traitement</h2></center>
				<form method="."post".">
					<div class="."col-sm-offset-3"."><input type="."submit"." value=".  "Oui"  ." name="."yes"." class=\"btn btn-info\" ></div>
				</form>
			</section>";

		if(isset($_POST['save']))
		{
			$xml = new DOMDocument('1.0', 'utf-8');
			$node = $xml->appendChild($xml->createElement("Info"));

			foreach($_POST as $key=>$value)
			{
				$req=$PDO_BDD->query("SELECT type from Fields where nom_Champs='$key'")->fetchAll();


				if($key !== 'save')
				{
					$newNode=$node->appendChild($xml->createElement($key,$value));
					foreach ($req as $type)
					{
						$typeChamp=$type['type'];
						$newNode->setAttribute("type","$typeChamp");
					}
				}
			}
			$xml->save('SavedData.xml');
			echo "<script> alert(\"Enregistrement réalisé avec succés !\")</script>";
			echo "<SCRIPT LANGUAGE='JavaScript'>window.open('SavedData.xml','_blank');</SCRIPT>";
			header('Refresh: 0');
		}

		if(isset($_POST['yes']))			
			header('Location: /OCR/php/Traitement.php');
		
		if(isset($_POST['deco']))
		{
			$_SESSION=array();
			session_destroy();
			header('Location: /OCR/php/Identification.php');
			exit();
		}
		echo "		</body>
	</html><br>";

	}
	else
		echo " <html>
					<head>
						<meta charset='UTF-8'>
					    <title>Finalisation</title>
						<link rel=\"stylesheet\" href=\"https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css\" integrity=\"sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7\" crossorigin=\"anonymous\">
						<link rel=\"stylesheet\" type=\"text/css\" href=\"style.css\">
					</head>
					<body style=\"background-image:url(img/fond.jpg); overflow-x: hidden; background-size:cover;\">
						<div class=\"row\">
							<p class=\"alert\"> Connectez vous pour avoir accés à cette partie du site. </p>
						<div class=\"row\">
						<div class=\"row\">
							<a href="."/OCR/php/Identification.php"." class=\"col-sm-offset-1\"> Se connecter !</a>
						<div class=\"row\">
					</body>
				</html>";
	ob_end_flush();
?>