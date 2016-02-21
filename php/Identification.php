<!DOCTYPE html>
	<?php
	include_once 'config.php';

	if(isset($_POST['OK']))
	{
		$login = $_POST['login'];	
		$password = $_POST['password'];	
		if($login&&$password)
		{
			
			$connect=$PDO_BDD->query("SELECT super_User FROM Users WHERE login LIKE '$login'and pwd LIKE '$password' ")->fetchAll();
			$superUser="0";
			foreach ($connect as $ligne) 
				$superUser=$ligne['super_User'];

		    ///////////RAJOUTER UN MESSAGE SI LOGIN OU MDP INVALIDE /////////////
		    if(count($connect) == 1)
		    {	
		    	if($superUser=="0")
		    	{
	    			session_start(); 
					$_SESSION['login']=$login;
					$_SESSION['admin']="false";
					header('Location: /OCR/php/Traitement.php');
		    	}
		    	else if($superUser=="1")
		    	{
		    		session_start(); 
					$_SESSION['login']=$login;
					$_SESSION['admin']="true";
					header('Location: /OCR/php/admin.php');
		    	}
		    	else
		    		echo "<script>alert(\"Erreur dans la base de donnée ! Veuillez contacter l'administrateur pour résoudre ce problème.\")</script>";		
			}
			else 
				echo "<script>alert(\"Erreur de connection : identifiant ou mot de passe incorrects.\")</script>";
		}
		else echo"Remplissez tous les champs";
	}
?>
<html>
	<head>
		<meta charset='UTF-8'>
		<title>Identification</title>
		<HR align=center size=1 width="50%">
		<center><strong><big><big><big>MyOCR</big></big></big></strong></center>
		<HR align=center size=1 width="50%">
	</head>
	<body>
	<form method="POST" action="/OCR/php/Identification.php"> 
	<div style="padding:10px; width:300px; margin:auto; border:1px solid ; ">  <!-- cadre bordure 1pxl, espacement 10 pxl, taille du cadre 300 pxl -->	
			
			<p>login 
			<input type="text" name="login"></p>					
			<p>mot de passe
			<input type="password" name="password"></p>

			<p><center>
				<input type="submit" name="OK" value="      OK      " 	>
				<input type="reset" name="Cancel" value="      Cancel      "  	></center>
			</p></div>	
			</form>		
															<!-- fin du formulaire -->
	</body>
</html>