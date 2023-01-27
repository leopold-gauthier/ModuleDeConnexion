<?php session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include("./stylesheet_inc.php") ?>
    <title>Inscription</title>
</head>

<body>
    <header>
        <?php
        include './header_inc.php' ?>
    </header>
    <main>
        <form id="editelement" method="post" action="inscription.php">

            <label class="editelement" for="login">Login </label>
            <input type="text" name="login" id="login" required />

            <label class="editelement" for="prenom">Prénom </label>
            <input type="text" name="prenom" id="prenom" required />

            <label class="editelement" for="nom">Nom </label>
            <input type="text" name="nom" id="nom" required />

            <label class="editelement" for="password">Mot de passe </label>
            <input type="password" name="password" id="password" required />

            <label class="editelement" for="cpassword">Confirmer mdp </label>
            <input type="password" name="cpassword" id="cpassword" required />

            <input class="bouton" type="submit" value="S'inscrire">
        </form>
        <?php
        //connexion à la base de données:
        include './connect.php';
        //par défaut, on affiche le formulaire (quand il validera le formulaire sans erreur avec l'inscription validée, on l'affichera plus)
        //traitement du formulaire:
        if (isset($_POST['login'], $_POST['prenom'], $_POST['nom'], $_POST['password'])) { //l'utilisateur à cliqué sur "S'inscrire", on demande donc si les champs sont défini avec "isset"
            if (empty($_POST['login']) || empty($_POST['prenom']) || empty($_POST['nom']) || empty($_POST['password']) || empty($_POST['cpassword'])) { //le champ login est vide, on arrête l'exécution du script et on affiche un message d'erreur
                echo "Un champ est vide.";
            } elseif (!preg_match("#^[a-z0-9]+$#", $_POST['login'])) { //le champ login est renseigné mais ne convient pas au format qu'on souhaite qu'il soit, soit: que des lettres minuscule + des chiffres (je préfère personnellement enregistrer le login de mes membres en minuscule afin de ne pas avoir deux login identique mais différents comme par exemple: Admin et admin)
                echo "Le login doit être renseigné en lettres minuscules sans accents, sans caractères spéciaux.";
            } elseif ($_POST['password'] != $_POST['cpassword']) {
                echo 'Les deux mots de passe sont differents';
            } elseif (mysqli_num_rows(mysqli_query($mysqli, "SELECT * FROM utilisateurs WHERE login='" . $_POST['login'] . "'")) == 1) { //on vérifie que ce login n'est pas déjà utilisé par un autre membre
                echo "Ce login est déjà utilisé.";
            } else {
                //toutes les vérifications sont faites, on passe à l'enregistrement dans la base de données:
                //Bien évidement il s'agit là d'un script simplifié au maximum, libre à vous de rajouter des conditions avant l'enregistrement comme la longueur minimum du mot de passe par exemple
                if (!mysqli_query($mysqli, "INSERT INTO utilisateurs SET login='" . $_POST['login'] . "',prenom='" . $_POST['prenom'] . "',nom='" . $_POST['nom'] . "', password='" . $_POST['password'] . "'")) { //on peut crypte le mot de passe avec la fonction propre à PHP: md5() : md5($_POST['password'])
                    echo "Une erreur s'est produite: " . mysqli_error($mysqli); //je conseille de ne pas afficher les erreurs aux visiteurs mais de l'enregistrer dans un fichier log
                } else {
                    echo "Vous étes maintenant inscrit";
                    // header('Location: connexion.php');
                    //on affiche plus le formulaire
                    $AfficherFormulaire = 0;
                }
            }
        }
        ?>
    </main>
    <footer>
        <?php include("./footer_inc.php") ?>
    </footer>
</body>

</html>