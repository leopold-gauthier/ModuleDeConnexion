<?php
session_start();
if (isset($_SESSION['users'][0]['login'])) {
  include("./connect.php");
} else {
  header("Location: connexion.php");
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php include("./stylesheet_inc.php") ?>
  <title>Edit Profile</title>
</head>

<body>
  <header>
    <?php include("./header_inc.php"); ?>
  </header>
  <main>
    <h1>Modifier votre profil : </h1>
    <div class="container">
      <form id="editelement" action="" method="POST">
        <div class="editelement">
          <label for="login">Votre pseudo</label>
          <input type="login" name="login" id="login" value="<?php echo $_SESSION['users'][0]['login']; ?>">
        </div>
        <div class="editelement">
          <label for="nom">Votre nom</label>
          <input type="text" name="nom" id="nom" value="<?php echo $_SESSION['users'][0]['nom'];   ?>">
        </div>
        <div class="editelement">
          <label for="prenom">Votre prénom</label>
          <input type="text" name="prenom" id="prenom" value="<?php echo $_SESSION['users'][0]['prenom'];  ?>">
        </div>
        <div class="editelement">
          <label for="confirm_password">Mot de passe actuelle</label>
          <input type="password" name="confirm_password" id="confirm_password">
        </div>
        <button class="bouton" type="submit" name="submit">Confirmer</button>
      </form>
    </div>
    <?php
    $id = $_SESSION['users'][0]['id'];
    //traitement du formulaire:
    if (isset($_POST['login'], $_POST['prenom'], $_POST['nom'], $_POST['confirm_password'])) { //l'utilisateur à cliqué sur "S'inscrire", on demande donc si les champs sont défini avec "isset"
      if (!preg_match("#^[a-z0-9]+$#", $_POST['login'])) { //le champ login est renseigné mais ne convient pas au format qu'on souhaite qu'il soit, soit: que des lettres minuscule + des chiffres (je préfère personnellement enregistrer le login de mes membres en minuscule afin de ne pas avoir deux login identique mais différents comme par exemple: Admin et admin)
        echo "Le login doit être renseigné en lettres minuscules sans accents, sans caractères spéciaux.";
      } elseif ($_POST['confirm_password'] !== $_SESSION['users'][0]['password']) {
        echo "Mot de passe inconnue";
      } elseif (mysqli_num_rows(mysqli_query($mysqli, "SELECT * FROM utilisateurs WHERE login='" . $_POST['login'] . "' AND id != '" . $_SESSION['users'][0]['id'] . "'")) == 1) { //on vérifie que ce login n'est pas déjà utilisé par un autre membre
        echo "Ce login est déjà utilisé.";
      } else {
        //toutes les vérifications sont faites, on passe à l'enregistrement dans la base de données:
        //Bien évidement il s'agit là d'un script simplifié au maximum, libre à vous de rajouter des conditions avant l'enregistrement comme la longueur minimum du mot de passe par exemple
        if (!mysqli_query($mysqli, "UPDATE utilisateurs SET login='" . $_POST['login'] . "',prenom='" . $_POST['prenom'] . "',nom='" . $_POST['nom'] . "' WHERE id  ='$id'")) { //on peut crypte le mot de passe avec la fonction propre à PHP: md5() : md5($_POST['password'])
          echo "Une erreur s'est produite: " . mysqli_error($mysqli); //je conseille de ne pas afficher les erreurs aux visiteurs mais de l'enregistrer dans un fichier log
        } else {
          $_SESSION['users'][0]['login'] = $_POST['login'];
          $_SESSION['users'][0]['nom'] = $_POST['nom'];
          $_SESSION['users'][0]['prenom'] = $_POST['prenom'];
          header('Location: editprofile.php');
          echo "Les modification on été appliqué.";
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