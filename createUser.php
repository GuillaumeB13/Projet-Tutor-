<?php
namespace Models;
require_once"/vendor/autoload.php";
require_once"bootstrap.php";

$newUserLogin = "utilisateur";
$newUserPassword = "Test123";
$newUserMail ="Utilisateurtest@test.test";
$newUserNom = "nomTest";
$newUserPrenom = "Test";
$newUserSuperUser = false;
$newUserTel = '0666666666';

$user = new Users();

$user -> setLogin($newUserLogin);
$user -> setPassword($newUserPassword);
$user -> setMail($newUserMail);
$user -> setNom($newUserNom);
$user -> setPrenom($newUserPrenom);
$user -> setSuperUser($newUserSuperUser);
$user -> setTel($newUserTel);

$entityManager -> persist($user);
$entityManager -> flush();

echo "Utilisateur créé avec l'id : ". $user -> getIdUsers().'\n';
