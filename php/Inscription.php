<!DOCTYPE html>
<?php
	include_once 'config.php';
	session_start();
?>
<?php
echo "
<html>
			<head>
				<meta charset='UTF-8'>
				<title> Traitement </title>
				<link rel=\"stylesheet\" href=\"https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css\" integrity=\"sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7\" crossorigin=\"anonymous\">
			</head>
			<body class=\"backbody\"><br>
				<div class=\"background2\">
					<form method =\"post\" class=\"col-sm-offset-10\">
				<p>
			        <label for="pseudo">Pseudo</label><br />
					<input type="text" name="pseudo" id="pseudo" size="30" />
			        <br />			
					<br />

					<label for="nom">Nom</label><br />
					<input type="text" name="nom" id="nom" size="30" />
			        <br />			
					<br />

					<label for="prenom">Prénom</label><br />
					<input type="text" name="prenom" id="prenom" size="30" />
			        <br />			
					<br />

					<label for="tel">Téléphone</label><br />
					<input type="text" name="tel" id="tel" size="30" />
			        <br />			
					<br />
								
					<label for="mdp">Mot de passe</label><br />
					<input type="password" name="mdp" id="mdp" size="30" /><br />
					<br />		
					<br />
									
					<label for="mdp_confirm">Confirmez votre mot de passe</label><br />
					<input type="password" name="mdp_confirm" id="mdp_confirm" size="30" />
			        <br />		
					<br />
									
					<label for="mail">Adresse email</label><br />
					<input type="email" name="mail" id="mail" size="30" /><br />
									
					<label for="mail_confirm">Confirmez votre adresse email</label><br />
					<input type="email" name="mail_confirm" id="mail_confirm" size="30" />
			        <br />			
					<br />
									
					<input type="submit" value="Valider" class="valider" />
			  	</p>
			</body>
</html>
		<style type=\"text/css\">
			.backbody
			{
				background-color: #D8D8D8;
			}
		</style>";