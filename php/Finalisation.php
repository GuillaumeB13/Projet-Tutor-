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
			<body>
				<div class="."titre"."> 
					<h2>Aperçu des champs récupérés</h2>
				</div>
				<section>
					<form method="."post".">
						<input type="."submit"." value="."Déconnexion"." name="."deco"." > <br><br>";
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
								echo "$champs[$i]".' '.'<input type="text" value="'.$var[$i].'" name="'.$champs[$i].'""> <br><br>';
						}
					echo "
					<center>
						<h2>Enregistrer les données récupérées ?</h2>
					</center>

					<div class="."save".">
						<input type="."submit"." value="."Enregistrer les modifications"." name="."save"." >
					</div>

				</form>
			</section>
			<section>
				<center><h2>Recommencer le traitement</h2></center>
				<form method="."post".">
					<div class="."yes"."><input type="."submit"." value=".  "Oui"  ." name="."yes"." ></div>
				</form>
			</section>
		</body>
	</html>";


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
						<link rel=\"stylesheet\" href=\"https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css\" integrity=\"sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7\" crossorigin=\"anonymous\">
						<meta charset='UTF-8'>
					    <title>Finalisation</title>
						<link rel="."stylesheet"." href="."Finalisation.css".">
					</head>
					<body>
						<p> Connectez vous pour avoir accés à cette partie du site. </p>
						<br>
						<a href="."/OCR/php/Identification.php"."> Se connecter !</a>
					</body>
				</html>";
?>