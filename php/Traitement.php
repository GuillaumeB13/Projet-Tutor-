<!DOCTYPE html>
<?php
	include_once 'config.php';
	session_start();
?>
<?php
	if (isset($_SESSION['login']))
	{
		echo "
		<html >
			<head>
				<meta charset='UTF-8'>
				<title> Traitement </title>				
				<link rel=\"stylesheet\" href=\"https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css\" integrity=\"sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7\" crossorigin=\"anonymous\">
				<script type=\"text/javascript\" src=\"./camanjs/dist/caman.full.js\"></script>
				<script src=\"//code.jquery.com/jquery-1.12.0.min.js\"></script>
				<script type=\"text/javascript\" src=\"traitement.js\"></script>
			</head>
			<body style=\"background-image:url(img/fond.jpg); overflow-x: hidden; background-size:cover; \">
				<div class=\"background2\">
					<form method =\"post\" class=\"col-sm-offset-10\">
						<input type="."submit"." value="."Déconnexion"." name="."deco"." class=\"btn btn-warning\" style=\"margin-top:10px;\"> <br><br>
					</form>
					<h1 class=\"titreh1 col-sm-offset-4\">Aperçu de l'image</h1><br><br>
					<form method=\"post\" enctype=\"multipart/form-data\">
						<h3 class=\"titre col-sm-offset-2\"> Etape 1 : Choisir une image. </h3><br><br>
						<i><font color=\"white\">Choisir une image de maximum 1500*1500 pixels. Autrement, l'image ne sera pas prise en compte.</font></i><br><br>
						<input style=\"color:white;\"type=\"file\" name=\"fichier\" class=\"col-sm-offset-3\"/><br>
						<input type=\"submit\" name=\"afficher\" class=\"btn btn-info col-sm-offset-3\" value=\"Générer l'image ?\">
					</form>";

		if(isset($_POST['afficher']))
		{

			$fichierUti = '/var/www/html/OCR/php/img/'; // destination du fichier
			$fichier = $_FILES['fichier']['tmp_name'];
			if( is_uploaded_file($fichier) ) // vérifie l'existence du fichier
			{
				$type_file = $_FILES['fichier']['type'];
				if(strstr($type_file, 'png')) // vérification de l'extension
				{
					$_FILES['fichier']['name']='ci.png';
					$nomFichier = $_FILES['fichier']['name'];
					if( move_uploaded_file($fichier, $fichierUti . $nomFichier) ) // copie du fichier et renvoie d'une erreur sinon
					{
						echo "<script> alert(\"Image généré !\")</script>";
					}
					else
						echo "<script>alert(\"Impossible de copier de le fichier.\")</script>";
				}
				else
					echo "<script>alert(\"Fichier non conforme. (conforme : .,png, .jpg)\")</script>";
			}
			else
				echo "<script>alert(\"Fichier introuvable.\")</script>";		
		}

		echo "
				<br><br><h3 class=\"titre col-sm-offset-2\">Etape 2: Modification de l'image si nécessaire.</h3>
				<canvas id=\"canvas\"></canvas>
				<table style=\"display:inline-block\" class=\" col-sm-offset-5\" >
					<form id=\"silderInput\">
						<tr>
							<td>
							<font color=\"white\" for=\"luminosite\">Luminosité</font>
							</td>
							<td>
							<input id=\"luminosite\" name=\"luminosite\" type=\"range\" min=\"-50\" max=\"50\" value=\"0\">
							</td>
						</tr>
						<tr>
							<td>
							<font color=\"white\" for=\"contraste\">Contraste</font>
							</td>
							<td>
							<input id=\"contraste\" name=\"contraste\" type=\"range\" min=\"-50\" max=\"50\" value=\"0\">
							</td>
						</tr>
						<tr>
							<td>
							<input type=\"button\" value=\"+\" name=\"plus\" id=\"rotp\">
							</td>
							<td>
							<font color=\"white\">Rotation </font>
							</td>
							<td>
							<input type=\"button\" value=\"-\" name=\"moins\" id=\"rotm\">
							</td>
						</tr>
					</form>
				</table>
			</div><br><br><br>
			<section>
				<h3 class=\"titre col-sm-offset-2\">Etape 3 : Choix du type de document et traitement.</h3><br><br>
				<div class=\"row\">
					<form method=\"post\" >
						<select name=\"select\" class=\"input-small col-sm-offset-3  \">
							<option value=\"vide\">Type du document à envoyer</option>";
								$req = $PDO_BDD->query("SELECT nom_Doc from Documents")->fetchAll();
								foreach($req as $ligne)
									echo '<option value="' . htmlentities($ligne['nom_Doc']) . '">' . $ligne['nom_Doc'] . '</option>';
							echo "
							</select>
							<br><br>
							<input class=\"btn btn-success col-sm-offset-3\" type=\"submit\" name=\"OCR\" value=\"Lancer le traitement ?\" />
						</form> 
					</div>
				</section><br><br>
			</body>
		</html>
		<style>
			.titreh1
			{
				color:#FF4000;
			}
			.titre
			{
				color:#088A08;
			}
		</style>";


		if(isset($_POST['OCR']))
		{
			if($_POST['select']=='vide')
				echo "<script> alert(\"Veuillez renseignez le type de document\")</script>";
			else
			{
				$req=$PDO_BDD->query('SELECT id_Doc from Documents where nom_Doc="'.$_POST['select'].'"');
				foreach ($req as $value)
					$idMask=$value['id_Doc'];

				$req=$PDO_BDD->query('SELECT Masks.id_Masks FROM Masks join Documents on Masks.id_Masks=Documents.id_Doc where Masks.id_Docs="$idMask"')->fetchAll();
				foreach ($req as $value)
					$_SESSION['type_masque']=$value['id_Masks'];

				$_SESSION['type_masque']=1; // pour le moment car seulement CI => aprés on mettra une requete SQL ect ...
				$req=$PDO_BDD->query('SELECT nom_Champs,type,x1,y1,x2,y2 from Champs where id_Masks="'.$_SESSION['type_masque'].'"')->fetchAll();
				$monfichier = fopen('/var/www/html/OCR/php/config/config.txt', 'r+');

				$i=0;

				foreach($req as $ligne)
				{
					$i++;
					if($i < sizeof($req))
					{
						$txt=$ligne['nom_Champs'].' '.$ligne['type'].' '.$ligne['x1'].' '.$ligne['y1'].' '.$ligne['x2'].' '.$ligne['y2'].' '.'n'."\n";
						fputs($monfichier, $txt);
					}
					else if($i == sizeof($req))
					{
						$txt=$ligne['nom_Champs'].' '.$ligne['type'].' '.$ligne['x1'].' '.$ligne['y1'].' '.$ligne['x2'].' '.$ligne['y2'].' '.'f'."\n";
						fputs($monfichier, $txt);
					}
				}

				fclose($monfichier);
				exec('/var/www/html/OCR/php/script.sh');
				header('Location: /OCR/php/Finalisation.php');
				exit();
			}
		}
		if(isset($_POST['deco']))
		{
			$_SESSION=array();
			session_destroy();
			header('Location: /OCR/php/Identification.php');
			exit();
		}
	}
	else 
		echo " <html>
					<head>
						<meta charset='UTF-8'>
					    <title>Traitement</title>
						<link rel=\"stylesheet\" href=\"https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css\" integrity=\"sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7\" crossorigin=\"anonymous\">
					</head>
					<body style=\"background-image:url(img/fond.jpg); overflow-x: hidden; background-size:cover;\">
						<div class=\"row\">
							<p class=\"alert\"> Connectez vous pour avoir accés à cette partie du site. </p>
						<div class=\"row\">
						<div class=\"row\">
							<a href="."/OCR/php/Identification.php"." class=\"col-sm-offset-1\"> Se connecter !</a>
						<div class=\"row\">
					</body>
				</html>
				<style type=\"text/css\">
					.alert
					{
						color: red;
					}
				</style>";
?>