<?php
	ob_start();
	include_once 'config.php';
	session_start();
?>
<?php
	if(isset($_SESSION['login']) && isset($_SESSION['admin']) && $_SESSION['admin']=="true")
	{
		echo "
		<html>
			<head>
			    <link rel=\"stylesheet\" href=\"https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css\" integrity=\"sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7\" crossorigin=\"anonymous\">
				<meta charset='UTF-8'>
				<title>Administrateur</title>
				<h1>Zone Administrateur</h1> <br><br>
			</head>
			<body class=\"backbody\">
				<div>
					<button type=\"button\" class=\"btn btn-success\" onclick=\"toggle_text('ajoutUti');\">Ajouter un utilisateur</button><br><br>
					<form method =\"post\" class=\"col-sm-offset-1\">
						<span style=\"display:none;\" id=\"ajoutUti\">
					        <label for=\"pseudo\">Pseudo</label><br>
							<input type=\"text\" name=\"pseudo\" id=\"pseudo\" size=\"30\" required/>
					        <br><br>

							<label for=\"nom\">Nom</label><br>
							<input type=\"text\" name=\"nom\" id=\"nom\" size=\"30\" required/>
					        <br><br>

							<label for=\"prenom\">Prénom</label><br>
							<input type=\"text\" name=\"prenom\" id=\"prenom\" size=\"30\" required/>
					        <br><br>

							<label for=\"tel\">Téléphone</label><br>
							<input type=\"text\" name=\"tel\" id=\"tel\" size=\"30\" required/>
					        <br><br>
										
							<label for=\"mdp\">Mot de passe</label><br>
							<input type=\"password\" name=\"mdp\" id=\"mdp\" size=\"30\" required/>
							<br><br>
											
							<label for=\"mdp_confirm\">Confirmez votre mot de passe</label><br>
							<input type=\"password\" name=\"mdp_confirm\" id=\"mdp_confirm\" size=\"30\" required/>
					        <br><br>
											
							<label for=\"mail\">Adresse email</label><br>
							<input type=\"email\" name=\"mail\" id=\"mail\" size=\"30\" required/>
							<br><br>
											
							<input type=\"submit\" name= \"valid\" value=\"Valider\" class=\"btn btn-info\" />
					  	</span>
					</form>
				</div>
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
		</style>
		<script>
			function toggle_text(id) 
			{
				if(document.getElementById(id).style.display == \"none\")
				    document.getElementById(id).style.display = \"block\";
				else
				    document.getElementById(id).style.display = \"none\";
			}
		</script>";

		if(isset($_POST['valid']))
		{
			$pseudobdd = $PDO_BDD->query('SELECT COUNT(login) as login FROM Users WHERE login = "'.$_POST['pseudo'].'"');
			$reqpseudo =   $pseudobdd->fetch();
			$pseudoexist = $reqpseudo['login'];
		    if($pseudoexist>=1)
		    	echo "<script>alert(\"Ce pseudo est déjà utilisé.\")</script>";
		    else
		    {
	    		$reqID = $PDO_BDD->query('SELECT max(id_Users) as id FROM Users');
				$IDtab =   $reqID->fetch();
				$IDActu = $IDtab['id']+1;
				$supUser =0;

    	        $PDO_BDD->exec(" INSERT INTO Users (login, id_Users,pwd,super_User,mail,nom,prenom,tel) VALUES ('".$_POST['pseudo']."', '$IDActu', '".$_POST['mdp']."', '$supUser', '".$_POST['mail']."','".$_POST['nom']."','".$_POST['prenom']."','".$_POST['tel']."') ");

    	        echo "<script>alert(\"Enregistrement de '".$_POST['pseudo']."' effective !\")</script>";
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
	ob_end_flush();
?>