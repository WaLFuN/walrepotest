<?php
session_start();

if (isset($_SESSION['mail'])) {
    include 'header.php';
} else {
    header('Location: login.php');
    exit();
}

try {
    $pdo = new PDO('mysql:host=localhost;dbname=voyage', 'root', '');
} catch (Throwable $th) {
    die(('Erreur : ' . $th->getMessage()));
}

$sql = 'SELECT * FROM voyages';

$response = $pdo->prepare($sql);
$response->execute();





?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Parcourir</title>
</head>

<body>
    <div class="col-8 offset-2">
        <?php

        while ($article = $response->fetch(PDO::FETCH_ASSOC)) {

            echo utf8_encode(('<article class="article"><div><h2 class="titleA">' . $article['title'] . '</h2><p>' . $article['content'].'</p></div><div><img class="img" src='.$article['image'].'></img></div></article>'));
        }

        ?>


    </div>




</body>

</html>