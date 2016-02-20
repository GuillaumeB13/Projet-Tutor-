<!DOCTYPE html>
<?php
	include_once 'config.php';
	session_start();
?>
<html>
	<head>
		<meta charset="UTF-8">
	    <title>Finalisation</title>
		<link rel="stylesheet" href="Finalisation.css">
	</head>
	<body>
		<div class="titre"> 
			<h2>Aperçu des champs récupérés</h2>
		</div>
		<section>
			<form action="" method="post">
				<?php
					// requete php pour recupérer nom des type de champs à récupérer en BDD (correspond aux noeuds dans le doc xml)
					$req=$PDO_BDD->query("SELECT type_Champs FROM `Champs` WHERE id_Masks=1")->fetchAll();
					// stockages des types dans le tableau
					$xml = simplexml_load_file('SavedData.xml'); // ouverture du XML

					$var=array();
					$champs=array();

					foreach($req as $ligne)
					{
						$var[] = $xml->$ligne['type_Champs'];
						$champs[] = $ligne['type_Champs'];
					}
					
					for($i=0;$i<sizeof($var);$i++)
					{
						if ($champs[$i]=="PhotoID" || $champs[$i]=="Signature")
						{
							$data=base64_decode($var[$i]);
							$img=imagecreatefromstring($data);
							imagepng($img);

						}
						else
							echo "$champs[$i]".' '.'<input type="text" value="'.$var[$i].'" "> <br><br>';
					}

					//test
  					$xml = new DOMDocument('1.0', 'utf-8');
				   
				    
					$node = $xml->appendChild($xml->createElement("para"));
					$node2 = $node->appendChild($xml->createElement("pacra","ee"));
					$node3 = $node->appendChild($xml->createElement("parca","ddd"));

  					$xml->save('nouveauFichier.xml');

				?>
			</form>
		</section>
		<section>
			<center><h2>Enregistrer les données récupérées ?</h2></center>
			<div class="save"><input type="button" value="  Save  " name="save" ></div>
		</section>
		<section3>
			<center><h2>Recommencer le traitement</h2></center>
			<div class="yes"><input type="button" value="  Oui  " name="yes" ></div>
		</section3>
	</body>
</html>