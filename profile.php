<?php
session_start();
if (!empty($_SESSION["login"])) {
  var_dump($_SESSION);
  include("./connect.php");
} else {
  header("Location: connexion.php");
}
?>

<?php
if (isset($_POST['submit'])) //verif d'envoi du formulaire
{
  $id = $_SESSION['users'][0]['id'];
  $login = $_SESSION['users'][0]['login'];
  $nom = $_SESSION['users'][0]['nom'];



  if (!$_POST['login'] == NULL) //verif changement pour le login
  {
    $_SESSION['users'][0]['login'] = $_POST['login'];
    $req = $mysqli->query("UPDATE utilisateurs SET login = '$login' WHERE `id`  =  '$id' ");
  }
  if (!$_POST['nom'] == NULL) //verif changement pour le nom
  {
    $_SESSION['users'][0]['nom'] = $_POST['nom'];
    $req = $mysqli->query("UPDATE utilisateurs SET nom = '$nom' WHERE `id`  =  '$id' ");
  }
  header('Location: profile.php'); //rafraichissement de la page pour remettre les valeurs affichées dans les inputs à jour


  // echo "Les modification ont bien été prise en compte / rafraichissement";
}
?>
<h1>Modifier votre profil : </h1>

<form method="post" id="test-form">

  <label for="login">Votre login</label>
  <input type="text" name="login" value="<?php echo $_SESSION['users'][0]['login'];   ?>">

  <label for="nom">Votre nom</label>
  <input type="text" name="nom" value="<?php echo $_SESSION['users'][0]['nom'];   ?>">


  <input class="bouton" type="submit" name="submit" value="Confirmer">
</form>