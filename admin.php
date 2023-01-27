<?php
session_start();
if ($_SESSION['users'][0]['login'] != 'admin') {
    header("Location: connexion.php");
}
include "connect.php";
$request = $mysqli->query('SELECT `login` , `prenom` , `nom`, `password` FROM utilisateurs');
$result = $request->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include("./stylesheet_inc.php") ?>
    <title>Admin</title>
</head>

<body>
    <header>
        <?php require "header_inc.php" ?>
    </header>
    <main>
        <table>
            <thead>
                <tr>
                    <?php
                    foreach ($result[0] as $key => $value) : ?>
                        <th><?= $key ?></th>
                    <?php endforeach; ?>
                </tr>
            </thead>
            <tbody>
                <?php for ($i = 0; $i < sizeof($result); $i++) : ?>
                    <tr>
                        <td><?= $result[$i]['login'] ?></td>
                        <td><?= $result[$i]['prenom'] ?></td>
                        <td><?= $result[$i]['nom'] ?></td>
                        <td><?= $result[$i]['password'] ?></td>
                    </tr>
                <?php endfor; ?>
            </tbody>
        </table>
    </main>
    <footer>
        <?php include("./footer_inc.php") ?>
    </footer>
</body>

</html>

<style>
    table {
        margin: 5% 0% 5% 0%;
        border-collapse: collapse;
    }

    th {
        color: rgba(245, 176, 47, 0.742);
        border: 1px rgba(245, 176, 47, 0.742) solid;
    }

    td {
        color: white;
        border: 1px rgba(245, 176, 47, 0.742) solid;
    }
</style>