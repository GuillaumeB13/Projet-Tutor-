<?php
	if (isset($_SESSION['login']) && isset($_SESSION['admin']))
	{
		include_once 'config.php';
		// requete php pour recupérer nom des type de champs à récupérer en BDD (correspond aux noeuds dans le doc xml)
		$req=$PDO_BDD->query('SELECT nom_Champs FROM Fields WHERE id_Masks="'.$_SESSION['id_Mask'].'"')->fetchAll();
		$typeHTML=$PDO_BDD->query('SELECT typeHTML FROM Fields WHERE id_Masks="'.$_SESSION['id_Mask'].'"')->fetchAll();
		$req2=$PDO_BDD->query('SELECT nom_Champs FROM Fields WHERE id_Masks="'.$_SESSION['id_Mask'].'" and type="image"')->fetchAll();
		// stockages des types dans le tableau
		$xml = simplexml_load_file('SavedData.xml'); // ouverture du XML
		$html=array();
		$var=array();
		$champs=array();
		foreach ($typeHTML as $key)
			$html[] = $key['typeHTML'];

		foreach($req as $ligne)
		{
			$var[] = $xml->$ligne['nom_Champs'];
			$champs[] = $ligne['nom_Champs'];
		}
		foreach ($req2 as $ligne) 
			$type[]= $ligne['nom_Champs'];
		echo"<div class=\"col-sm-offset-1\">";
		for($i=0;$i<sizeof($var);$i++)
		{
			if($html[$i]!=='image')
				echo "<div class=\"padding\"><font size=\"3\" color=\"white\" class=\"col-sm-offset-1\">$champs[$i]</font>".' '.'<input type="'.$html[$i].'" value="'.$var[$i].'" name="'.$champs[$i].'""><br></div>';
			else
				echo "<div class=\"padding\"><font size=\"3\" color=\"white\" class=\"col-sm-offset-1\">$champs[$i]</font>".' '.'<input type="text" value="'.$var[$i].'" name="'.$champs[$i].'""><br></div>';
			for($x=0;$x<sizeof($type);$x++)
				if ( $champs[$i]===$type[$x] )
					echo "<img style=\"vertical-align:top;\" class=\"padding\" src=\"data:image/png;base64,".$var[$i]."\"/>";
		}
		echo "</div>";
	}
	else
		echo " <html>
				<head>
					<meta charset='UTF-8'>
				    <title>Finalisation</title>
				    <link rel=\"stylesheet\" type=\"text/css\" href=\"style.css\">
					<link rel=\"stylesheet\" href=\"https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css\" integrity=\"sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7\" crossorigin=\"anonymous\">
				</head>
				<body style=\"background-image:url(img/fond.jpg); overflow-x: hidden; background-size:cover;\">
					<div class=\"row\">
						<p class=\"alert\"> ERROR 404 ! Vous n'avez pas accés à cette partie du site. </p>
					<div class=\"row\">
					<div class=\"row\">
						<a href="."/OCR/php/Identification.php"." class=\"col-sm-offset-1\"> Retour à la page d'identification.</a>
					<div class=\"row\">
				</body>
			</html>";
?>