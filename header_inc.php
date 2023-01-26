<nav>
    <?php

    if (isset($_SESSION['users'][0]['login'])) { ?>

        <a href="./index.php">ACCUEIL</a>
        <a href="./editprofile.php">PROFIL</a>
        <a href="./logout.php">LOGOUT</a>

        <?php
        if ($_SESSION['users'][0]['login'] == 'admin') { ?>
            <a href="./admin.php">ADMIN</a>
        <?php
        }
    } else { ?>
        <a href="./index.php">ACCUEIL</a>
        <a href="./connexion.php">CONNECTER</a>
        <a href="./inscription.php">INSCRIPTION</a>
    <?php
    }
    ?>
</nav>