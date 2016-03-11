<?php
	ob_start();
	include_once 'config.php';
	session_start();
?>
<?php
	if(isset($_SESSION['login']) && isset($_SESSION['admin']) && $_SESSION['admin']=="true")
	{
		list($canvasWidth, $canvasHeight) = getimagesize("img/ci.png"); 
		echo "
		
		<html>
			<head>
				<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />
				<title>Ajout de masque</title>
				<script type=\"text/javascript\" src=\"gestion.js\"></script>
				<link rel=\"stylesheet\" href=\"https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css\" integrity=\"sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7\" crossorigin=\"anonymous\">
			</head>
			<body onload=\"init()\" style=\"background-image:url(img/fond.jpg); overflow-x: hidden; background-size:cover;\">
				<div class=\"row\">
					<h1 class=\"titreh1 col-sm-4 col-sm-offset-4\" style=\"margin-top:10px;\"> Zone Administrateur </h1>
					<form method =\"post\" class=\"col-sm-2 col-sm-offset-2\">
						<input type="."submit"." value="."Déconnexion"." name="."deco"." class=\"btn btn-warning\" style=\"margin-top:10px;\"> <br><br>
					</form>
				</div>
				<div>
					<br><br><br><br>
					<div class=\"row\">
						<div class=\"col-sm-4 col-sm-offset-1\">
							<button type=\"button\" class=\"btn btn-success\" onclick=\"toggle_text('ajoutUti'); \">Ajouter un utilisateur</button><br><br>
							<form method =\"post\" class=\"col-sm-offset-1\">
								<span style=\"display:none;\" id=\"ajoutUti\">
							        <font color=\"white\" for=\"pseudo\">Pseudo</font><br>
									<input type=\"text\" name=\"pseudo\" id=\"pseudo\" size=\"30\" required/>
							        <br><br>

									<font color=\"white\" for=\"nom\">Nom</font><br>
									<input type=\"text\" name=\"nom\" id=\"nom\" size=\"30\" required/>
							        <br><br>

									<font color=\"white\" for=\"prenom\">Prénom</font><br>
									<input type=\"text\" name=\"prenom\" id=\"prenom\" size=\"30\" required/>
							        <br><br>

									<font color=\"white\" for=\"tel\">Téléphone</font><br>
									<input type=\"text\" name=\"tel\" id=\"tel\" size=\"30\" required/>
							        <br><br>
												
									<font color=\"white\" for=\"mdp\">Mot de passe</font><br>
									<input type=\"password\" name=\"mdp\" id=\"mdp\" size=\"30\" required/>
									<br><br>
													
									<font color=\"white\" for=\"mdp_confirm\">Confirmez votre mot de passe</font><br>
									<input type=\"password\" name=\"mdp_confirm\" id=\"mdp_confirm\" size=\"30\" required/>
							        <br><br>
													
									<font color=\"white\" for=\"mail\">Adresse email</font><br>
									<input type=\"email\" name=\"mail\" id=\"mail\" size=\"30\" required/>
									<br><br>
													
									<input type=\"submit\" name= \"valid\" value=\"Valider\" class=\"btn btn-info\" />
							  	</span>
							</form>
						</div>
						<div class=\"col-sm-4  col-sm-offset-1\">
							<button type=\"button\" class=\"btn btn-success\" onclick=\"toggle_text('ajoutDocMask'); \">Ajouter un document et un masque</button><br><br>
							<span style=\"display:none;\" id=\"ajoutDocMask\">
								<form method =\"post\" class=\"col-sm-offset-1\">
										<h4 class=\"titre\"> Ajouter un document : </h4><br>
								        <font color=\"white\" for=\"nomDoc\">Nom du Document</font><br>
										<input type=\"text\" name=\"nomDoc\" size=\"30\" required/>
								        <br><br>
								        <font color=\"white\" for=\"idMask\">ID du masque à associer avec le document (facultatif)</font><br>
										<input type=\"text\" name=\"idMask\" size=\"30\"/>
								        <br><br>
										<input type=\"submit\" name= \"ajoutDoc\" value=\"Valider\" class=\"btn btn-info\" /><br><br>
								</form>
								<form method =\"post\" class=\"col-sm-offset-1\">
									<h4 class=\"titre\"> Ajouter un masque : </h4><br>
									<font color=\"white\" for=\"nomMask\">Nom du Masque</font><br>
									<input type=\"text\" name=\"nomMask\" size=\"30\" required/>
							        <br><br>
							        <font color=\"white\" for=\"idDoc\">ID du document à associer avec le masque (facultatif)</font><br>
									<input type=\"text\" name=\"idDoc\" size=\"30\"/>
							        <br><br>
							        <input type=\"submit\" name= \"ajoutMask\" value=\"Valider\" class=\"btn btn-info\" /><br><br>

								</form>
								<form method =\"post\" class=\"col-sm-offset-1\">
									<h4 class=\"titre\"> Lier un document à un masque : </h4><br>
									<font color=\"white\" for=\"idM\">Choisir un document</font><br><select name=\"idD\" class=\"form-control\" required>";
									
									$req=$PDO_BDD->query('SELECT id_Doc,nom_Doc from Documents');
									foreach($req as $ligne)
										echo '<option value="' . htmlentities($ligne['id_Doc']).'">' . $ligne['nom_Doc'] . '</option>';
									echo"</select><br>
							        <font color=\"white\" for=\"idD\">Choisir un masque</font><br>
									<select name=\"idM\" class=\"form-control\">";
									$req=$PDO_BDD->query('SELECT id_Masks,nom_Masks from Masks');
									foreach($req as $ligne)
										echo '<option value="' . htmlentities($ligne['id_Masks']).'">' . $ligne['nom_Masks'] . '</option>';
									echo "
									</select>
							        <br><br>
							        <input type=\"submit\" name= \"liaison\" value=\"Valider\" class=\"btn btn-info\" /><br><br>
								</form>
							</span>
						</div>
					</div>
				<div  style=\"padding-left: 5px; \"> <br><br>
					
					<button type=\"button\" class=\"btn btn-success col-sm-offset-1\" onclick=\"toggle_text('ajoutChamp'); \">Ajouter un champs</button><br><br>
					<span style=\"display:none;\" id=\"ajoutChamp\">
						<h3 class=\"titre col-sm-offset-4\">Choisir une image </h3><br><br>
						<form method=\"post\" enctype=\"multipart/form-data\">
							<i><font color=\"white\">Choisir une image de maximum 1500*1500 pixels. Autrement, l'image ne sera pas prise en compte.</font></i><br><br>
							<input style=\"color:white;\"type=\"file\" name=\"fichier\" class=\"col-sm-offset-3\"/><br>
							<input type=\"submit\" name=\"afficher\" class=\"btn btn-info col-sm-offset-3\" value=\"Générer l'image ?\">
						</form>
						<div id=\"container\">
								<canvas id=\"canvas1\" width=\"$canvasWidth\" height=\"$canvasHeight\" style=\"border: 1px solid black;\"
							This text is displayed if your browser does not support HTML5 Canvas.
							</canvas>
						</div><br>
						<div class=\"col-sm-offset-1\">
							<h2 class=\"titre\"> Ajouter un champs </h2><br><br>
							<div class=\"col-sm-7\" style=\"font-family: Verdana; font-size: 14px;\">
								<span style=\"color:white;\">Cliquer pour sélectionner. Cliquer sur les poignées de sélection pour ajuster la taille. Double cliquer pour créer un nouveau champ. Appuyer sur la touche <kbd>suppr</kbd> pour supprimer un champ.</font>
							</div><br><br><br><br><br><br>
							<form name=\"f\" method=\"post\" >
								<h4 class=\"titre\"> Champ actuellement sélectionner<h4><br><br>
								<font color=\"white\" style=\"display:inline-block;\">Type </font>
								<select class=\"form-control \" style=\"width:100px;display:inline-block;\" name=\"type\" onchange=\"CanvasState.prototype.update()\" onkeydown=\"testForEnter();\">
									<option value=\"texte\">texte</option>
									<option value=\"image\">image</option>
								</select><br><br>
								<font color=\"white\">Nom du champ </font><input onkeypress=\"return verif(event);\" type=\"text\" name=\"nom_champ\" onchange=\"CanvasState.prototype.update()\"/><br><br>
								<font style=\"margin-top:20px; margin-bottom:20px;\" color=\"white\" > x1</font> <input readonly  type=\"text\" name=\"x\" onchange=\"CanvasState.prototype.update()\" /><font color=\"white\"> y1</font><input readonly  type=\"text\" name=\"y\" onchange=\"CanvasState.prototype.update()\"/><br><br>
								<font color=\"white\"> x2 </font></font> <input readonly  type=\"text\" name=\"w\" onchange=\"CanvasState.prototype.update()\"/> <font color=\"white\"> y2</font><input readonly  type=\"text\" name=\"h\" onchange=\"CanvasState.prototype.update()\" /><br><br>
								<font color=\"white\" style=\"display:inline-block;margin:7px;\" >Assigner au masque </font><select name=\"IDMASK\" class=\"form-control \" style=\"width:150px;display:inline-block;\" required></font>";
								$req=$PDO_BDD->query('SELECT id_Masks,nom_Masks from Masks');
								foreach($req as $ligne)
									echo '<option value="' . htmlentities($ligne['id_Masks']).'">' . $ligne['nom_Masks'] . '</option>';

								echo "</select><br><br>
								<input type="."submit"." value="."Valider"." name="."ajoutChamp"." class=\"btn btn-info\"> 
							</form>
						</div>
					</span>
				</div>
			</body>
		</html>
			<style type=\"text/css\">
				input#dis
				{
				  height: 30px;
				  width: 30px;;;
				}
				input#disabledInput
				{
				  height: 30px;
				  width: 50px;;;
				}
				.titreh1
				{
					font-family:Ubuntu;
					color:#FF4000;
				}
				.titre
				{
					color:#088A08;
				}
				.alert
				{
					color: red;
				}
			</style>
			<script>
				function toggle_text(id) 
				{
					if(document.getElementById(id).style.display == \"none\")
					    document.getElementById(id).style.display = \"block\";
					else
					    document.getElementById(id).style.display = \"none\";
				}
				function verif(evt) {
			        var keyCode = evt.which ? evt.which : evt.keyCode;
			        var accept = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789_-';
			        if (accept.indexOf(String.fromCharCode(keyCode)) >= 0) {
			            return true;
			        } else {
			            return false;
			        }
			    }
			</script>";
		if(isset($_POST['ajoutChamp']))
		{
			$champ=$_POST['nom_champ'];
			$verif=$PDO_BDD->query("SELECT nom_Champs FROM Fields WHERE nom_Champs = '$champ'")->fetchAll();
			if(count($verif)<1)
			{
				$reqID = $PDO_BDD->query('SELECT max(id_Champs) as id FROM Fields');
				$IDtab =   $reqID->fetch();
				$IDchamp = $IDtab['id']+1;

				$ajt=$PDO_BDD->exec("INSERT INTO Fields (id_Champs , id_Masks , nom_Champs , x1 , y1 , x2 , y2 , Type) VALUES ( '$IDchamp' , '".$_POST['IDMASK']."' , '$champ' , '".$_POST['x']."' , '".$_POST['y']."' , '".$_POST['w']." ' , '".$_POST['h']."' , '".$_POST['type']."' ) ");
				$nommasque=$PDO_BDD->query('SELECT nom_Masks from Masks where id_Masks="'.$_POST['IDMASK'].'"');
				echo "<script> alert(\"'".$_POST['nom_champ']."' à bien était ajouté au masque '".$_POST['nom_champ']."' \")</script>";
			}
			else
				echo "<script> alert(\"Le nom de champs '".$_POST['nom_champ']."' existe déjà !\")</script>";
		}

		if(isset($_POST['liaison']))
		{
			$IdDoc = $_POST['idD'];
			$IdMask = $_POST['idM'];
			$verifDoc=$PDO_BDD->query("SELECT nom_Doc FROM Documents WHERE id_Doc = '$IdDoc'")->fetchAll();
			$verifMask=$PDO_BDD->query("SELECT nom_Masks FROM Masks WHERE id_Masks = '$IdMask'")->fetchAll();
			foreach ($verifDoc as $key) 
				$nomD=$key['nom_Doc'];
			foreach ($verifMask as $key) 
				$nomM=$key['nom_Masks'];

			if(count($verifDoc)==1)
				if(count($verifMask)==1)
				{
					$ajt=$PDO_BDD->exec("UPDATE Masks SET id_Docs = '$IdDoc' WHERE id_Masks = '$IdMask'");
					$ajt=$PDO_BDD->exec("UPDATE Documents SET id_Masks = '$IdMask' WHERE id_Doc = '$IdDoc'");

					echo "<script> alert(\"$nomD et $nomM ont été lié avec succés !\")</script>";
				}
				else
					echo "<script> alert(\"L'ID du masque n'existe pas !\")</script>";
			else
	    		echo "<script> alert(\"L'ID du document n'existe pas !\")</script>";
		}

		if(isset($_POST['ajoutMask']))
		{
			$mask = $_POST['nomMask'];
			$verifMask=$PDO_BDD->query("SELECT nom_Masks FROM Masks WHERE nom_Masks LIKE '$mask'")->fetchAll();

			if(count($verifMask)>1)
			{
				$reqID = $PDO_BDD->query('SELECT max(id_Masks) as id FROM Masks');
				$IDtab =   $reqID->fetch();
				$IDmask = $IDtab['id']+1;
				
				$ajtDoc=$PDO_BDD->exec("INSERT INTO Masks (id_Masks, nom_Masks, id_Docs) VALUES ('$IDmask','$mask','".$_POST['idDoc']."')");	

				echo "<script> alert(\"$mask enregistrés !\")</script>";
				header("Refresh:0");
			}
			else
	    		echo "<script> alert(\"Le masque existe déjà !\")</script>";
		}

		if(isset($_POST['ajoutDoc']))
		{
			$doc = $_POST['nomDoc'];	
			$verifDoc=$PDO_BDD->query("SELECT nom_Doc FROM Documents WHERE nom_Doc LIKE '$doc'")->fetchAll();

	    	if(count($verifDoc)>1)
	    	{	
	    		$reqID = $PDO_BDD->query('SELECT max(id_Doc) as id FROM Documents');
				$IDtab =   $reqID->fetch();
				$IDdoc = $IDtab['id']+1;

	    		$ajtDoc=$PDO_BDD->exec("INSERT INTO Documents (id_Doc, nom_Doc, id_Masks) VALUES ('$IDdoc','$doc','".$_POST['idMask']."') ");

	    		echo "<script> alert(\"$doc enregistrés !\")</script>";
	    		header("Refresh:0");
	    	}
	    	else
	    		echo "<script> alert(\"Le document existe déjà !\")</script>";

		}
			
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
						header("Refresh:0");
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
		if(isset($_POST['deco']))
		{
			$_SESSION=array();
			session_destroy();
			unlink('/var/www/html/OCR/php/img/ci.png');
			header('Location: /OCR/php/Identification.php');
			exit();
		}

		if(isset($_POST['valid']))
		{
			$pseudobdd = $PDO_BDD->query('SELECT COUNT(login) as login FROM Users WHERE login = "'.$_POST['pseudo'].'"');
			$reqpseudo =   $pseudobdd->fetch();
			$pseudoexist = $reqpseudo['login'];
		    if($pseudoexist>=1)
		    	echo "<script>alert(\"Ce login est déjà utilisé.\")</script>";
		    else
		    {
	    		$reqID = $PDO_BDD->query('SELECT max(id_Users) as id FROM Users');
				$IDtab =   $reqID->fetch();
				$IDActu = $IDtab['id']+1;
				$supUser =0;

    	        $PDO_BDD->exec(" INSERT INTO Users (login, id_Users,pwd,super_User,mail,nom,prenom,tel) VALUES ('".$_POST['pseudo']."', '$IDActu', '".$_POST['mdp']."', '$supUser', '".$_POST['mail']."','".$_POST['nom']."','".$_POST['prenom']."','".$_POST['tel']."') ");

    	        echo "<script>alert(\"Enregistrement de '".$_POST['pseudo']."' effectif !\")</script>";
		    }

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
			.backbody
			{
				background-color: #D8D8D8;
			}
			.alert
			{
				color: red;
			}
			</style>";
	ob_end_flush();
?>
