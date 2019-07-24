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

$sql = 'INSERT INTO voyages VALUES(NULL, :title, :content, :image)';


if (isset($_POST['title']) && isset($_POST['content'])) {

    $title = $_POST['title'];
    $content = $_POST['content'];
    $image = $_POST['image'];

    $request = $pdo->prepare($sql);
    $request->execute([
        ':title' => htmlentities(strip_tags($title)),
        ':content' => htmlentities(strip_tags($content)),
        ':image' => $image
    ]);

    header('Location: acceuil.php');

}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>News Travel</title>
</head>

<body>

    <form action="" method="post">
        <div class="form-group offset-3 col-2 my-6">
            <label for="title">Title</label>
            <input type="text" class="form-control" id="title" name="title" placeholder="Votre titre">
        </div>
        <div class="form-group offset-3 col-6 my-6">
            <label for="image"">Image</label>
            <input type="text" class="form-control" id="image" name="image" placeholder="Inserer le lien -www- de votre image">
        </div>

        <div class="form-group offset-3 col-6 my-6">
            <label for="content"">Content</label>
            <textarea class=" form-control" name="content" id="content" rows="6"></textarea>
        </div>




        <button class="btn btn-success offset-9" type="submit">Ajouter</button>

    </form>

</body>

</html>