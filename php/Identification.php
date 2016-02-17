<!DOCTYPE html>
<?php
session_start(); 
ini_set('display_errors','off');
if(isset($_POST['OK']))
{
	$login = $_POST['login'];	
	$password = $_POST['password'];	
if($login&&$password)
	{
		
		$connect = mysql_connect('localhost','root','');
		mysql_select_db('myocr');
		
		$query=mysql_query("SELECT * FROM identification WHERE (login='$login'and password='SHA1($password'))");
		$rows=mysql_num_rows($query);		
		if ($rows==0)
		{		
			header('Location:Traitement.php');		
		}else echo "pseudo ou password incorrect";
	}
	else echo"Remplissez tous les champs";
}
?>
<head>
<HR align=center size=1 width="50%">
<center><strong><big><big><big>MyOCR</big></big></big></strong></center>
<HR align=center size=1 width="50%">
</head>
	<body>
	<form method="POST" action="identification.php"> 
	<div style="padding:10px; width:300px; margin:auto; border:1px solid ; ">  <!-- cadre bordure 1pxl, espacement 10 pxl, taille du cadre 300 pxl -->	
			
			<p>login 
			<input type="text" name="login"></p>					
			<p>mot de passe
			<input type="password" name="password"></p>

			<p><center>
				<input type="submit" name="OK" value="      OK      " 	>
				<input type="submit" name="Cancel" value="      Cancel      "  	></center>
			</p></div>	
			</form>		
															<!-- fin du formulaire -->
	</body>
</html>