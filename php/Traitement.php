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
			</head>
			<body class=\"backbody\"><br>
				<div class=\"background2\">
					<form method =\"post\" class=\"col-sm-offset-10\">
						<input type="."submit"." value="."Déconnexion"." name="."afficher"." class=\"btn btn-warning\"> <br><br>
					</form>
					<h1 class=\"col-sm-offset-4\">Fenetre d'aperçu de l'image</h1><br><br>
					<form method=\"post\" enctype=\"multipart/form-data\">
						<input type=\"file\" name=\"fichier\" class=\"col-sm-offset-3\"/><br>
						<input type=\"submit\" name=\"afficher\" class=\"btn btn-success col-sm-offset-3\" value=\"Afficher l'image ?\">
					</form>";

		if(isset($_POST['afficher']))
		{

			$fichierUti = '/var/www/html/OCR/php/img/'; // destination du fichier
			$fichier = $_FILES['fichier']['tmp_name'];
			if( !is_uploaded_file($fichier) ) // vérifie l'existence du fichier
			{
					echo "<script>alert(\"Fichier introuvable.\")</script>";
			}
			$type_file = $_FILES['fichier']['type'];
			if(strstr($type_file, '.png') ) // vérification de l'extension
			{
					echo "<script>alert(\"Fichier non conforme. (conforme : .png\")</script>";
			}
			$_FILES['fichier']['name']='ci.png';
			$nomFichier = $_FILES['fichier']['name'];
			if( !move_uploaded_file($fichier, $fichierUti . $nomFichier) ) // copie du fichier et renvoie d'une erreur sinon
			{
					echo "<script>alert(\"Impossible de copier de le fichier.\")</script>";
			}
		
			echo "<br><br><img class=\"img-rounded col-sm-offset-3\" src=\"/OCR/php/img/ci.png\" height=\"352\" width=\"600\"/>";
		}

		echo "
					<br><br><h3 class=\"col-sm-offset-2\">Paramétrage image</h3><br><br>
				</div>
				<section>
					<h3 class=\"col-sm-offset-2\">Choix du type de document</h3><br><br>
					<div class=\"row\">
						<form method=\"post\" >
							<select name=\"select\" class=\"col-sm-offset-3\">
								<option value=\"vide\">Type du document à envoyer</option>";

										$req = $PDO_BDD->query("SELECT nom_Doc from Documents")->fetchAll();
										foreach($req as $ligne)
										{
											echo '<option value='.$ligne['nom_Doc'].'>'.$ligne['nom_Doc'].'</option>';
										}
							echo "
							</select>
							<br><br>
							<input class=\"btn btn-success col-sm-offset-3\" type=\"submit\" name=\"OCR\" value=\"Lancer le traitement ?\" />
						</form> 
					</div>
				</section>
			</body>
		</html>
		<style type=\"text/css\">
			.backbody
			{
				background-color: #D8D8D8;
			}
		</style>";


		if(isset($_POST['OCR']))
		{
			if($_POST['select']=='vide')
			{
				echo "<script> alert(\"Veuillez renseignez le type de document\")</script>";
			}
			else
			{
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