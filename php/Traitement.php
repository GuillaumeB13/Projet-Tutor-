<!DOCTYPE html>
<?php
	include_once 'config.php';
	session_start();
?>
<?php
	if (isset($_SESSION['login']))
	{
		echo "
		<html>
			<head>
				<meta charset='UTF-8'>
				<title> Traitement </title>
				<link rel=\"stylesheet\" href=\"Traitement.css\"/>
			</head>
			<body>
				<form method =\"post\">
					<input type="."submit"." value="."Déconnexion"." name="."deco"." > <br><br>
				</form>
					<div class=\"titre1\"><h2>Fenetre d'aperçu de l'image</h2></div>

					<h2>Paramétrage image</h2>

				<section3>
					<h3><center>Choix du type de document</center></h3>
					<div class=\"menu\">
						<form method=\"post\">
							<select name=\"select\">
								<option value=\"vide\">Type du document à envoyer</option>";

										$req = $PDO_BDD->query("SELECT nom_Doc from Documents")->fetchAll();
										foreach($req as $ligne)
										{
											echo '<option value='.$ligne['nom_Doc'].'>'.$ligne['nom_Doc'].'</option>';
										}
							echo "
							</select>
							<br><br>
							<input type=\"submit\" name=\"OCR\" value=\"Lancer le traitement ?\" />
						</form>
					</div>
				</section3>
			</body>
		</html>";


		if(isset($_POST['OCR']))
		{
			if($_POST['select']=='vide')
			{
				echo "<script> alert(\"Veuillez renseignez le type de document\")</script>";
			}
			else
			{
				$_SESSION['type_masque']=1; // pour le moment car seulement CI => aprés on mettra une requete SQL ect ...
				$req=$PDO_BDD->query('SELECT type_Champs,x1,y1,x2,y2 from Champs where id_Masks="'.$_SESSION['type_masque'].'"')->fetchAll();
				$monfichier = fopen('/var/www/html/OCR/php/config/config.txt', 'r+');

				$i=0;

				foreach($req as $ligne)
				{
					$i++;
					if($i < sizeof($req))
					{
						$txt=$ligne['type_Champs'].' '.$ligne['x1'].' '.$ligne['y1'].' '.$ligne['x2'].' '.$ligne['y2'].' '.'n'."\n";
						fputs($monfichier, $txt);
					}
					else if($i == sizeof($req))
					{
						$txt=$ligne['type_Champs'].' '.$ligne['x1'].' '.$ligne['y1'].' '.$ligne['x2'].' '.$ligne['y2'].' '.'f'."\n";
						fputs($monfichier, $txt);
					}
				}

				fclose($monfichier);
				exec('/var/www/html/OCR/php/script.sh');
				header('Location: /OCR/php/Finalisation.php');
			}
		}
		if(isset($_POST['deco']))
		{
			$_SESSION=array();
			session_destroy();
			header('Location: /OCR/php/Identification.php');
		}
	}
	else 
		echo " <html>
					<head>
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