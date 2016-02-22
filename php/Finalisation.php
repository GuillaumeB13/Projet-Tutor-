<!DOCTYPE html>
<?php
	ob_start();
	include_once 'config.php';
	session_start();
?>
<?php
	if (isset($_SESSION['login']))
	{
		echo"
		<html>
			<head>
				<link rel=\"stylesheet\" href=\"https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css\" integrity=\"sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7\" crossorigin=\"anonymous\">
				<meta charset='UTF-8'>
			    <title>Finalisation</title>
			</head>
			<body class=\"backbody\">
				<br>
				<form method=\"post\" class=\"col-sm-offset-10\">
					<input type="."submit"." value="."Déconnexion"." name="."deco"." class=\"btn btn-warning\">
				</form>
				<center>
					<h2>Aperçu des champs récupérés</h2>
				</center>
				<section>
					<form method="."post"." class=\"form-group\"><br><br>";
						// requete php pour recupérer nom des type de champs à récupérer en BDD (correspond aux noeuds dans le doc xml)
						$req=$PDO_BDD->query('SELECT type_Champs FROM `Champs` WHERE id_Masks="'.$_SESSION['type_masque'].'"')->fetchAll();
						// stockages des types dans le tableau
						$xml = simplexml_load_file('SavedData.xml'); // ouverture du XML

						$var=array();
						$champs=array();

						foreach($req as $ligne)
						{
							$var[] = $xml->$ligne['type_Champs'];
							$champs[] = $ligne['type_Champs'];
						}
						
						for($i=0;$i<sizeof($var);$i++)
						{
							/*if ($champs[$i]=="PhotoID" || $champs[$i]=="Signature")
							{
								$data=base64_decode($var[$i]);
								$img=imagecreatefromstring($data);
								imagepng($img);

							}
							else*/
								echo "<label class=\"col-sm-offset-1\">$champs[$i]</label>".' '.'<input type="text" value="'.$var[$i].'" name="'.$champs[$i].'""><br>';
						}
					echo "
					<center>
						<h2>Enregistrer les données récupérées ?</h2>
					</center>

					<div class="."col-sm-offset-3".">
						<input type="."submit"." value="."Enregistrer les modifications"." name="."save"." class=\"btn btn-success\">
					</div>

				</form>
			</section>
			<section>
				<center><h2>Recommencer le traitement</h2></center>
				<form method="."post".">
					<div class="."col-sm-offset-3 btn-success"."><input type="."submit"." value=".  "Oui"  ." name="."yes"." class=\"btn btn-success\" ></div>
				</form>
			</section>
		</body>
	</html>

	<style type=\"text/css\">
		.backbody
		{
			background-color: #D8D8D8;
		}
		label
		{
			display: block;
		    width: 150px;
		    float: left;
		}
	</script>";


		if(isset($_POST['save']))
		{
			//test
			$xml = new DOMDocument('1.0', 'utf-8');
			$node = $xml->appendChild($xml->createElement("Infp"));

			foreach($_POST as $key=>$value)
			{
				$newNode=$node->appendChild($xml->createElement($key,$value));
			}
			$xml->save('SavedData.xml');
		}

		if(isset($_POST['yes']))
		{
			header('Location: /OCR/php/Traitement.php');
		}
		if(isset($_POST['deco']))
		{
			$_SESSION=array();
			session_destroy();
			header('Location: /OCR/php/Identification.php');
		}

		ob_flush();
	}
	else
		echo " <html>
					<head>
						<meta charset='UTF-8'>
					    <title>Finalisation</title>
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