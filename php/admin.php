<?php
	ob_start();
	include_once 'config.php';
	session_start();
?>
<?php
	if(isset($_SESSION['login']) && isset($_SESSION['admin']) && $_SESSION['admin']=="true")
	{
		ini_set('upload_max_filesize', '10M');
		list($canvasWidth, $canvasHeight) = getimagesize("img/ci.png"); 
		echo "
		
		<html>
			<head>
				<meta http-equiv=\"Content-Type\" content=\"text/html\"; charset=\"utf-8\" />
				<title>Ajout de masque</title>
				<script type=\"text/javascript\" src=\"gestion.js\"></script>
				<link rel=\"stylesheet\" href=\"https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css\" integrity=\"sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7\" crossorigin=\"anonymous\">
			</head>
			<body class=\"container\" onload=\"init()\" style=\"background-image:url(img/fond.jpg); background-size:cover;\">
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
										<input type=\"submit\" name= \"ajoutDoc\" value=\"Valider\" class=\"btn btn-info\" /><br><br>
								</form>
								<form method =\"post\" class=\"col-sm-offset-1\">
									<h4 class=\"titre\"> Ajouter un masque : </h4><br>
									<font color=\"white\" for=\"nomMask\">Nom du Masque</font><br>
									<input type=\"text\" name=\"nomMask\" size=\"30\" required/>
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
					
					<button type=\"button\" class=\"btn btn-success col-sm-offset-1\" onclick=\"toggle_text('ajoutChamp'); \">Ajouter un champ</button><br><br>
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
							<h2 class=\"titre\"> Ajouter un champ </h2><br><br>
							<div class=\"col-sm-7\" style=\"font-family: Verdana; font-size: 14px;\">
								<span style=\"color:white;\">Cliquer pour sélectionner. Cliquer sur les poignées de sélection pour ajuster la taille. Double cliquer pour créer un nouveau champ. Appuyer sur la touche <kbd>suppr</kbd> pour supprimer un champ.</font>
							</div><br><br><br><br><br><br>
							<form name=\"f\" method=\"post\" >
								<h4 class=\"titre\"> Champ actuellement sélectionner<h4><br><br>
								<input type=\"hidden\" name=\"id\" onchange=\"CanvasState.prototype.update()\" onkeydown=\"testForEnter();\"/>
								<font color=\"white\" style=\"display:inline-block;\">Type (OCR) </font>
								<select class=\"form-control \" style=\"width:100px;display:inline-block;\" name=\"type\" onchange=\"CanvasState.prototype.update()\" onkeydown=\"testForEnter();\">
									<option value=\"texte\">texte</option>
									<option value=\"image\">image</option>
								</select><br><br>
								<font color=\"white\" style=\"display:inline-block;\">Type (affichage HTML) </font>
								<select class=\"form-control \" style=\"width:100px;display:inline-block;\" name=\"typeHTML\" onchange=\"CanvasState.prototype.update()\" onkeydown=\"testForEnter();\">
									<option value=\"text\">text</option>
									<option value=\"image\">image</option>
									<option value=\"date\">date</option>
									<option value=\"email\">email</option>
									<option value=\"number\">number</option>
									<option value=\"tel\">tel</option>
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
				</div> <br><br>
				<div  style=\"padding-left: 5px; \">
					<button type=\"button\" class=\"btn btn-success col-sm-offset-1\" onclick=\"toggle_text('modif'); \">Modification</button><br><br>
					<span class=\"col-sm-offset-1\" style=\"display:none;\" id=\"modif\">

						<button type=\"button\" class=\"btn btn-success col-sm-offset-1\" onclick=\"toggle_text('modifDoc'); \">Modfier les documents</button>
						<span class=\"col-sm-offset-1\" style=\"display:none;\" id=\"modifDoc\">
								<div style=\"display:inline-block;\"><br>
								<font style=\"margin:10px;\" class=\"titre\" size=\"4\"> Nom des documents </font><br><br>";

								$req=$PDO_BDD->query('SELECT nom_Doc,id_Doc from Documents');
									foreach($req as $ligne)
										echo '<form method="post" enctype="multipart/form-data" >
											<input  style="width:1px;visibility: hidden;" type="text" name="idDoc" value="' . htmlentities($ligne['id_Doc']).'">
											<input style="margin:10px;" name="nomDoc" value="' . htmlentities($ligne['nom_Doc']).'">


											<input class="btn btn-warning" type="submit" name="modifDoc" value="Modifier le document"><br>
										</form>
											';
							


								echo"</div><br><br>
						</span><br>

						<br>

						<button type=\"button\" class=\"btn btn-success col-sm-offset-1\" onclick=\"toggle_text('modifMasks'); \">Modifier les masques</button>
						<span class=\"col-sm-offset-1\" style=\"display:none;\" id=\"modifMasks\">
							<div style=\"display:inline-block;\"><br>
								<font style=\"margin:10px;\" class=\"titre\" size=\"4\"> Nom des masques </font><br><br>";

								$req=$PDO_BDD->query('SELECT nom_Masks,id_Masks from Masks');
								foreach($req as $ligne)
									echo '<form method="post" enctype="multipart/form-data" >
											<input  style="width:1px;visibility: hidden;" type="text" name="idMask" value="' . htmlentities($ligne['id_Masks']).'">
											<input style="margin:10px;" name="maskName" value="' . htmlentities($ligne['nom_Masks']).'">


											<input class="btn btn-warning" type="submit" name="modifMask" value="Modifier le masque"><br>
										</form>
											';

								echo"
								</div><br><br>
						</span><br>

						<br>

						<button type=\"button\" class=\"btn btn-success col-sm-offset-1\" onclick=\"toggle_text('modifChp'); \">Modifier les champs</button>
						<span class=\"col-sm-offset-1\" style=\"display:none;\" id=\"modifChp\"><br>
						<table class=\" table\">
						<tr>
							<td>
								<font class=\"titre\" color=\"white\" size=\"4\"> Nom du Champ </font> 
							</td>
							<td>
								<font class=\"titre\" color=\"white\" size=\"4\"> x1 </font> 
							</td>
							<td>
								<font class=\"titre\" color=\"white\" size=\"4\"> y1 </font>
							</td>
							<td>
								<font class=\"titre\" color=\"white\" size=\"4\"> x2 </font> 
							</td>
							<td>
								<font class=\"titre\" color=\"white\" size=\"4\"> y2 </font>
							</td>
							<td>
								<font class=\"titre\" color=\"white\" size=\"4\"> Type de champ (OCR) </font>
							</td>
							<td>
								<font class=\"titre\" color=\"white\" size=\"4\"> Type de champ (HTML) </font>
							</td>
							<td>
								<font class=\"titre\" color=\"white\" size=\"4\"> Validation </font>
							</td>
						</tr>";

								$req=$PDO_BDD->query('SELECT id_Champs,nom_Champs,x1,y1,x2,y2,typeHTML from Fields');
								$req2=$PDO_BDD->query('SELECT type from Fields');
								foreach($req as $ligne)
								{
									echo
									"
										<tr>
										<form method=\"post\">
											<td>
												<input onkeypress=\"return verif(event);\" name=\"nomChamps\" type=\"text\" value='".$ligne['nom_Champs']."'>
											</td>
											<td>
												<input onkeypress=\"return verif(event);\" style=\"width:50px;\" name=\"x1\" type=\"text\" value='".$ligne['x1']."'>
											</td>
											<td>
												<input onkeypress=\"return verif(event);\" style=\"width:50px;\" name=\"y1\" type=\"text\" value='".$ligne['y1']."'>
											</td>
											<td>
												<input onkeypress=\"return verif(event);\" style=\"width:50px;\" name=\"x2\" type=\"text\" value='".$ligne['x2']."'>
											</td>
											<td>
												<input onkeypress=\"return verif(event);\" style=\"width:50px;\" name=\"y2\" type=\"text\" value='".$ligne['y2']."'>
											</td>
											<td>
												<select name=\"selectType\" class=\"form-control\" >";
												$req3=$PDO_BDD->query('SELECT type from Fields where id_Champs="'.$ligne['id_Champs'].'"');
												foreach ($req3 as $key)
													$typeChampID=$key['type'];
												if($typeChampID==='texte')
													echo"
													<option selected value=\"texte\">texte</option>
													<option value=\"image\">image</option>";
												else
													echo"
													<option value=\"texte\">texte</option>
													<option selected value=\"image\">image</option>";
												
												echo "
												</select>
											</td>
											<td>
												<select name=\"selectTypeHTML\" class=\"form-control\" >";
												$req4=$PDO_BDD->query('SELECT typeHTML from Fields where id_Champs="'.$ligne['id_Champs'].'"');
												foreach ($req4 as $key)
													$typeChampID=$key['typeHTML'];
												if($typeChampID==='text')
													echo"
													<option selected value=\"texte\">texte</option>
													<option value=\"image\">image</option>
													<option value=\"date\">date</option>
													<option value=\"email\">email</option>
													<option value=\"number\">number</option>
													<option value=\"tel\">tel</option>
													";
												else if($typeChampID==='image')
													echo"
													<option value=\"texte\">texte</option>
													<option selected value=\"image\">image</option>
													<option value=\"date\">date</option>
													<option value=\"email\">email</option>
													<option value=\"number\">number</option>
													<option value=\"tel\">tel</option>";

												else if($typeChampID==='date')
													echo"
													<option value=\"texte\">texte</option>
													<option value=\"image\">image</option>
													<option selected value=\"date\">date</option>
													<option value=\"email\">email</option>
													<option value=\"number\">number</option>
													<option value=\"tel\">tel</option>";

												else if($typeChampID==='email')
													echo"
													<option value=\"texte\">texte</option>
													<option value=\"image\">image</option>
													<option value=\"date\">date</option>
													<option selected value=\"email\">email</option>
													<option value=\"number\">number</option>
													<option value=\"tel\">tel</option>";

												else if($typeChampID==='number')
													echo"
													<option value=\"texte\">texte</option>
													<option value=\"image\">image</option>
													<option value=\"date\">date</option>
													<option value=\"email\">email</option>
													<option selected value=\"number\">number</option>
													<option value=\"tel\">tel</option>";

												else if($typeChampID==='tel')
													echo"
													<option value=\"texte\">texte</option>
													<option value=\"image\">image</option>
													<option value=\"date\">date</option>
													<option value=\"email\">email</option>
													<option value=\"number\">number</option>
													<option selected value=\"tel\">tel</option>";
												
												echo "
												</select>
											</td>
											<td>
												<input class=\"btn btn-info\" type=\"submit\" name=\"modifChamp\" value=\"Valider modification\">
												<input style=\"width:1px; visibility: hidden;\" name=\"idChamp\" type=\"text\" value='".$ligne['id_Champs']."'>
											</td>
										</form>
										</tr>
									";
								}

								echo "</table>
								</div><br>
						</span><br>

					</span>
				</div>
				<div  style=\"padding-left: 5px; \">
					<button type=\"button\" class=\"btn btn-success col-sm-offset-1\" onclick=\"toggle_text('supr'); \">Suppression</button><br><br>
					<span class=\"col-sm-offset-1\" style=\"display:none;\" id=\"supr\">
						<form method=\"post\">
							<h4 class=\"titre\"> Supprimer un document :<h4>
							<select name=\"supprDoc\" class=\"form-control \" style=\"margin:5px; width:200px;display:inline-block;\" required>";

							$req=$PDO_BDD->query('SELECT nom_Doc,id_Doc from Documents');
								foreach($req as $ligne)
									echo '<option value="' . htmlentities($ligne['id_Doc']).'">' . $ligne['nom_Doc'] . '</option>';

						echo"
								<input class=\"btn btn-danger\" type=\"submit\" name=\"delDoc\" value=\"Supprimer le document\"><br>
						</form>
						<br>
						<form method=\"post\">
							<h4 class=\"titre\"> Supprimer un masque :<h4>
							<select name=\"supprMask\" class=\"form-control \" style=\"margin:5px; width:200px;display:inline-block;\" required>";

							$req=$PDO_BDD->query('SELECT nom_Masks,id_Masks from Masks');
								foreach($req as $ligne)
									echo '<option value="' . htmlentities($ligne['id_Masks']).'">' . $ligne['nom_Masks'] . '</option>';

						echo"
							<input class=\"btn btn-danger\" type=\"submit\" name=\"delMask\" value=\"Supprimer le masque\">	<br>
						</form>
						<br>
						<form method=\"post\">
							<h4 class=\"titre\"> Supprimer un champ :<h4>
							<select name=\"supprChamp\" class=\"form-control \" style=\"margin:5px; width:200px;display:inline-block;\" required>";

							$req=$PDO_BDD->query('SELECT nom_Champs,id_Champs from Fields');
								foreach($req as $ligne)
									echo '<option value="' . htmlentities($ligne['id_Champs']).'">' . $ligne['nom_Champs'] . '</option>';

						echo"
							<input class=\"btn btn-danger\" type=\"submit\" name=\"delChamp\" value=\"Supprimer le champ\">	<br>
						</form>
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
				function verif(evt) 
				{
			        var keyCode = evt.which ? evt.which : evt.keyCode;
			        var accept = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789_-';
			        if (accept.indexOf(String.fromCharCode(keyCode)) >= 0) 
			            return true;
			        else 
			            return false;
			        
			    }
			</script>";
		if(isset($_POST['delDoc']))
		{
			$req=$PDO_BDD->exec("UPDATE Masks set id_Docs=NULL where id_Docs='".$_POST['supprDoc']."'");
			$req=$PDO_BDD->exec("DELETE from Documents where id_Doc='".$_POST['supprDoc']."'");
			$req=$PDO_BDD->exec("UPDATE Documents set id_Doc=id_Doc-1 where id_Doc>'".$_POST['supprDoc']."'");
			$req=$PDO_BDD->exec("UPDATE Masks set id_Docs=id_Docs-1 where id_Docs>'".$_POST['supprDoc']."'");

			echo "<script> alert(\"Document supprimé ! \")</script>";
			header("Refresh:0");

		}

		if(isset($_POST['delMask']))
		{
			$req=$PDO_BDD->exec("UPDATE Documents set id_Masks=NULL where id_Masks='".$_POST['supprMask']."'");
			$req=$PDO_BDD->exec("UPDATE Fields set id_Masks=NULL where id_Masks='".$_POST['supprMask']."'");
			$req=$PDO_BDD->exec("DELETE from Masks where id_Masks='".$_POST['supprMask']."'");
			$req=$PDO_BDD->exec("UPDATE Masks set id_Masks=id_Masks-1 where id_Masks>'".$_POST['supprMask']."'");
			$req=$PDO_BDD->exec("UPDATE Documents set id_Masks=id_Masks-1 where id_Masks>'".$_POST['supprMask']."'");
			$req=$PDO_BDD->exec("UPDATE Fields set id_Masks=id_Masks-1 where id_Masks>'".$_POST['supprMask']."'");

			echo "<script> alert(\"Masque supprimé ! \")</script>";
			header("Refresh:0");
		}

		if(isset($_POST['delChamp']))
		{
			$req=$PDO_BDD->exec("DELETE from Fields where id_Champs='".$_POST['supprChamp']."'");
			$req=$PDO_BDD->exec("UPDATE Fields set id_Champs=id_Champs-1 where id_Champs>'".$_POST['supprChamp']."'");

			echo "<script> alert(\"Champ supprimé ! \")</script>";
			header("Refresh:0");
		}

		if(isset($_POST['modifDoc']))
		{
			$id=$_POST['idDoc'];
			$update=$PDO_BDD->exec("UPDATE Documents set nom_Doc='".$_POST['nomDoc']."' where id_Doc='$id'");

			echo "<script> alert(\"Document modifié !\")</script>";

			header("Refresh:0");
		}

		if(isset($_POST['modifMask']))
		{
			$iDm=$_POST['idMask'];
			$update=$PDO_BDD->exec("UPDATE Masks set nom_Masks='".$_POST['maskName']."' where id_Masks='$iDm'");

			echo "<script> alert(\"Masque modifié !\")</script>";

			header("Refresh:0");
		}

		if(isset($_POST['modifChamp']))
		{
			$id=$_POST['idChamp'];
			$update=$PDO_BDD->exec("UPDATE Fields set nom_Champs='".$_POST['nomChamps']."',x1='".$_POST['x1']."',y1='".$_POST['y1']."',x2='".$_POST['x2']."',y2='".$_POST['y2']."',Type='".$_POST['selectType']."', typeHTML='".$_POST['selectTypeHTML']."' where id_Champs='$id'");
		
			echo "<script> alert(\"Champ modifié !\")</script>";

			header("Refresh:0");
		}

		if(isset($_POST['ajoutChamp']))
		{
			$champ=$_POST['nom_champ'];
			$verif=$PDO_BDD->query("SELECT nom_Champs FROM Fields WHERE nom_Champs = '$champ'")->fetchAll();
			if(count($verif)<1)
			{
				$reqID = $PDO_BDD->query('SELECT max(id_Champs) as id FROM Fields');
				$IDtab =   $reqID->fetch();
				$IDchamp = $IDtab['id']+1;

				$ajt=$PDO_BDD->exec("INSERT INTO Fields (id_Champs , id_Masks , nom_Champs , x1 , y1 , x2 , y2 , Type, typeHTML) VALUES ( '$IDchamp' , '".$_POST['IDMASK']."' , '$champ' , '".$_POST['x']."' , '".$_POST['y']."' , '".$_POST['w']." ' , '".$_POST['h']."' , '".$_POST['type']."', '".$_POST['typeHTML']."' ) ");
				$nommasque=$PDO_BDD->query('SELECT nom_Masks from Masks where id_Masks="'.$_POST['IDMASK'].'"');
				echo "<script> alert(\"'".$_POST['nom_champ']."' à bien était ajouté au masque '".$_POST['nom_champ']."' \")</script>";
			}
			else
				echo "<script> alert(\"Le nom de champs '".$_POST['nom_champ']."' existe déjà !\")</script>";
			header("Refresh:0");
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
	    	header("Refresh:0");
		}

		if(isset($_POST['ajoutMask']))
		{
			$mask = $_POST['nomMask'];
			$verifMask=$PDO_BDD->query("SELECT nom_Masks FROM Masks WHERE nom_Masks LIKE '$mask'")->fetchAll();

			if(count($verifMask)<1)
			{
				$reqID = $PDO_BDD->query('SELECT max(id_Masks) as id FROM Masks');
				$IDtab =   $reqID->fetch();
				$IDmask = $IDtab['id']+1;
				
				$ajtDoc=$PDO_BDD->exec("INSERT INTO Masks (id_Masks, nom_Masks, id_Docs) VALUES ('$IDmask','$mask',NULL)");	

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

	    	if(count($verifDoc)<1)
	    	{	
	    		$reqID = $PDO_BDD->query('SELECT max(id_Doc) as id FROM Documents');
				$IDtab =   $reqID->fetch();
				$IDdoc = $IDtab['id']+1;

	    		$ajtDoc=$PDO_BDD->exec("INSERT INTO Documents (id_Doc, nom_Doc, id_Masks) VALUES ('$IDdoc','$doc',NULL) ");

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
						header("Refresh:0");
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
		if(isset($_POST['deco']))
		{
			$_SESSION=array();
			session_destroy();
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
		    header("Refresh:0");

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

	if(isset($_POST['deco']))
	{
		$_SESSION=array();
		session_destroy();
		header('Location: /OCR/php/Identification.php');
		exit();
	}

	
	ob_end_flush();
?>
