<?php
	if(isset($_POST['save']))
	{
		//test
		$xml = new DOMDocument('1.0', 'utf-8');
		echo "dmrr";

		$node = $xml->appendChild($xml->createElement("para"));

		foreach($_POST as $key=>$value)
		{
			echo "LOOOL";
			$node->appendChild($xml->createElement("'$key'","$value"));
		}
		$xml->save('nouveauFichier.xml');
	}


?>