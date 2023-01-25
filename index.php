<?php
// Initialiser la session
session_start();
// Vérifiez si l'utilisateur est connecté, sinon redirigez-le vers la page de connexion
if (!isset($_SESSION["user"])) {
    // header("Location: ./connexion.php");
    // exit();
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include("./stylesheet_inc.php") ?>
    <title>Accueil</title>
</head>

<body>
    <header><?php require "header_inc.php"; ?></header>
    <main>
        <h1>Welcome
            <?php if (isset($_SESSION['users'][0]['login'])) {
                echo $_SESSION['users'][0]['login'];
            } else {
                echo "";
            } ?> !
        </h1>
        <?php if (isset($_SESSION['users'][0]['login'])) { ?>
            <p>Bon retour parmis nous !</p>
        <?php
        } else { ?>
            <p><a href="connexion.php">Connectez</a> ou <a href="inscription.php">s'inscire</a>
            </p>
        <?php
        }
        ?>
    </main>
    <footer>
        <?php include("./footer_inc.php") ?>
    </footer>
</body>

</html>