<?php
// Connexion à la base de données MySQL 
$mysqli = new mysqli('localhost', 'root', '', 'moduleconnexion');
//$mysqli = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Vérifier la connexion
if ($mysqli === false) {
    die("ERREUR : Impossible de se connecter. " . mysqli_connect_error());
}
