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
				<link rel=\"stylesheet\" type=\"text/css\" href=\"style.css\">
				<script type=\"text/javascript\" src=\"./camanjs/dist/caman.full.js\"></script>
				<script src=\"//code.jquery.com/jquery-1.12.0.min.js\"></script>
				<script type=\"text/javascript\" src=\"traitement.js\"></script>
			</head>
			<body class=\"container\" style=\"background-image:url(img/fond.jpg); overflow-x: hidden; background-size:cover; \">
				<div class=\"row\">
					<div class=\"col-sm-5 col-sm-offset-1\">
						<h1 class=\"titreh1\"> Traitement du document </h1>
					</div>
					<div class=\"col-sm-4\">
						<form method=\"post\" class=\"col-sm-offset-12\">
							<input type="."submit"." value="."Déconnexion"." name=\"deco\" class=\"btn btn-warning\" style=\"margin-top:25px;\"/>
						</form>
					</div>
				</div>
				<br><br>
				<form method=\"post\" enctype=\"multipart/form-data\">
					<h3 class=\"titre col-sm-offset-2\"> Etape 1 : Choisir une image. </h3><br><br>
					<i><font style=\"margin-left:25px;\" color=\"white\">Choisir une image de maximum 1500*1500 pixels. Autrement, l'image ne sera pas prise en compte.</font></i><br><br>
					<input style=\"color:white;\"type=\"file\" name=\"fichier\"/><br>
					<input type=\"submit\" name=\"afficher\" class=\"btn btn-info \" value=\"Générer l'image ?\">
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

			header("Refresh:0");			
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
							<input style=\"background-color: rgb(92, 184, 92);\" id=\"luminosite\" name=\"luminosite\" class=\"range\"type=\"range\" min=\"-50\" max=\"50\" value=\"0\"><br>
							</td>
						</tr>
						<tr>
							<td>
							<font color=\"white\" for=\"contraste\">Contraste</font>
							</td>
							<td>
							<input style=\"background-color: rgb(92, 184, 92);\" id=\"contraste\" name=\"contraste\"class=\"range\" type=\"range\" min=\"-50\" max=\"50\" value=\"0\"><br>
							</td>
						</tr>
						<tr>
							<td>
							<input type=\"button\" value=\"+\" class=\"btn btn-success\" name=\"plus\" id=\"rotp\">
							</td>
							<td>
							<font color=\"white\">Rotation </font>
							</td>
							<td>
							<input type=\"button\" value=\"-\" class=\"btn btn-success\" name=\"moins\" id=\"rotm\">
							</td>
						</tr>
					</form>
				</table>
			</div><br><br><br>
			<section>
				<h3 class=\"titre col-sm-offset-2\">Etape 3 : Choix du type de document et traitement.</h3><br><br>
				<div class=\"row\">
					<form method=\"post\" >
						<select style=\"width:225px; height:30px;\" name=\"typeDocMasks\" class=\"input-small col-sm-offset-3  \">
							<optgroup label=\"Document\"><option class=\"form-control\" value=\"vide\" >Nom du masque</option>";
								$req = $PDO_BDD->query("SELECT nom_Doc,id_Doc from Documents")->fetchAll();
								foreach($req as $ligne)
								{
									$idDocument=$ligne['id_Doc'];
									echo '<optgroup label="' . htmlentities($ligne['nom_Doc']) . '">';
									$req2=$PDO_BDD->query("SELECT id_Masks,nom_Masks FROM Masks where id_Docs='$idDocument' ")->fetchAll();

									foreach ($req2 as $key) 
										echo '<option value="'.htmlentities($key['id_Masks']).'">'.htmlentities($key['nom_Masks']).'</option>';
									echo '</optgroup>';
								}
							echo "
							</select>
							<br><br>
							<input class=\"btn btn-success col-sm-offset-3\" type=\"submit\" name=\"OCR\" value=\"Lancer le traitement ?\" />
						</form> 
					</div>
				</section><br><br>
			</body>
		</html>";


		if(isset($_POST['OCR']))
		{
			if($_POST['typeDocMasks']=='vide')
				echo "<script> alert(\"Veuillez renseignez le type de document\")</script>";
			else
			{
				$_SESSION['id_Mask']=$_POST['typeDocMasks'];

				$req=$PDO_BDD->query('SELECT nom_Champs,type,x1,y1,x2,y2 from Fields where id_Masks="'.$_SESSION['id_Mask'].'"')->fetchAll();
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
						<link rel=\"stylesheet\" type=\"text/css\" href=\"style.css\">
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
				</html>";
?>