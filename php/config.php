<?php
	ini_set('display_errors', 1);
	
    define('DB_HOST', 'localhost');
	define('DB_PORT', '');
	define('DB_DATABASE', 'MyOCR');
	define('DB_USERNAME', 'root');
	define('DB_PASSWORD', 'root');
	try
	{
		$PDO_BDD = new PDO('mysql:host='.DB_HOST.';port='.DB_PORT.';dbname='.DB_DATABASE, DB_USERNAME, DB_PASSWORD);
		$PDO_BDD->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //Emet des exceptions
		$PDO_BDD->exec("SET NAMES 'utf8'"); //Codage utilisé
	}

	catch(Exception $e) //Interception de l'erreur
	{
		echo 'Erreur : '.$e->getMessage().'<br>'.'Numero : '.$e->getCode();
		exit();
	}

?>