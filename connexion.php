<?php
//à mettre tout en haut du fichier .php, cette fonction propre à PHP servira à maintenir la $_SESSION
session_start();
?>


<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include("./stylesheet_inc.php") ?>
    <title>Connexion</title>
</head>

<body>
    <header>
        <?php require "header_inc.php" ?>
    </header>
    <main>
        <form method="post">
            <h1>Connexion</h1>
            <input type="text" name="login" placeholder="Nom d'utilisateur">
            <input type="password" name="password" placeholder="Mot de passe">
            <input type="submit" value="connexion " name="connexion">
            <?php
            if (isset($_SESSION['users'][0]['login'])) { ?>
                <p><a href="./logout.php">Déconnexion</a></p>

            <?php
                header("Location: ./index.php");
            } else { ?>
                <p>Vous êtes nouveau ici? <a href="./inscription.php">S'inscrire</a></p>
            <?php
            }
            ?>
        </form>

        <?php
        //si le bouton "Connexion" est cliqué
        if (isset($_POST['connexion'])) {
            // on vérifie que le champ n'est pas vide
            // empty vérifie à la fois si le champ est vide et si le champ existe belle et bien (is set)
            if (empty($_POST['login']) || empty($_POST['password'])) {
                echo "Un champ est vide.";
            } else {
                // les champs login & password sont bien postés et pas vides, on sécurise les données entrées par l'utilisateur
                //le htmlentities() passera les guillemets en entités HTML, ce qui empêchera en partie, les injections SQL
                $login = htmlentities($_POST['login'], ENT_QUOTES, "UTF-8");
                $MotDePasse = htmlentities($_POST['password'], ENT_QUOTES, "UTF-8");
                //on se connecte à la base de données:
                include 'connect.php';
                //on vérifie que la connexion s'effectue correctement:
                if (!$mysqli) {
                    echo "Erreur de connexion à la base de données.";
                } else {
                    //on fait maintenant la requête dans la base de données pour rechercher si ces données existent et correspondent:
                    //si vous avez enregistré le mot de passe en md5() il vous faudra faire la vérification en mettant password = '".md5($MotDePasse)."' au lieu de password = '".$MotDePasse."'
                    $Requete = $mysqli->query("SELECT * FROM utilisateurs WHERE login = '" . $login . "' AND password = '" . $MotDePasse . "'");
                    $result = $Requete->fetch_all(MYSQLI_ASSOC);
                    //si il y a un résultat, mysqli_num_rows() nous donnera alors 1
                    //si mysqli_num_rows() retourne 0 c'est qu'il a trouvé aucun résultat
                    if (mysqli_num_rows($Requete) == 0) {
                        echo "<p>Le login ou le mot de passe est incorrect, le compte n'a pas été trouvé.</p>";
                    } else {
                        //on ouvre la session avec $_SESSION:
                        //la session peut être appelée différemment et son contenu aussi peut être autre chose que le login
                        echo "Vous êtes à présent connecté !";

                        $_SESSION['users'] = $result;
                        header("Location: ./index.php");
                    }
                }
            }
        }
        ?>
    </main>
    <footer>
        <?php include("./footer_inc.php") ?>
    </footer>
</body>