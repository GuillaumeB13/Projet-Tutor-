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
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
		<meta charset='UTF-8'>
		<title>Identification</title>
	</head>
	<body>
		<HR class="col-sm-offset-3" size=1 width="50%">
		<h1 class="col-sm-offset-5 text-success">MyOCR</h1>
		<HR class="col-sm-offset-3" size=1 width="50%"> <br><br><br>
		<form method="POST" action="/OCR/php/Identification.php"> 

		<form class="form-horizontal">
		  <div class="form-group row">
		    <label class="col-sm-1 col-sm-offset-2 control-label">Login</label>
		    <div class="col-sm-4">
		      <input type="text" class="form-control col-sm-offset-3" name="login" placeholder="Login">
		    </div>
		  </div>
		  <div class="form-group row">
		    <label for="inputPassword3" class="col-sm-1 col-sm-offset-2 control-label">Password</label>
		    <div class="col-sm-4">
		      <input type="password" class="form-control col-sm-offset-3" id="inputPassword2" placeholder="Mot de passe" name="password"><br>
		    </div>
		  </div>
		  <div class="form-group row">
		    <div class="col-sm-offset-2 col-sm-10">
		      <button type="submit" class="btn btn-success col-sm-offset-3" name="OK">Se connecter</button>
		    </div>
		  </div>	
															<!-- fin du formulaire -->
	</body>
</html>