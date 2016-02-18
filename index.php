<?php
require_once"bootstrap.php"

$newUser = "utilisateur";

$user = new User();

$user-> setLogin($newUser);

$entityManager -> persist($user);
$entityManager ->flush();

echo "Utilisateur créé avec l'id : ". $user ->getIdUsers().'\n';
