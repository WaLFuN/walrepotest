<?php

///////////////////////////////////////////////// Démarre la session 

session_start();

///////////////////////////////////////////////// Sécurisation de la page

if (isset($_SESSION['logok'])) {
    if($_SESSION['logok'] == 1){
    } else {
        header("Location: index.php?deco");
    }
} else {
    header("Location: index.php?deco");
}

if (isset($_FILES['image'])) { 
    
}

///////////////////////////////////////////////// Préparation des $_POST

if (isset($_POST['titre']) && isset($_POST['contenu']) && isset($_FILES['image']['name'])) {
    $titre = $_POST['titre'];
    $contenu = $_POST['contenu'];
    $image = $_FILES['image']['name'];

    ///////////////////////////////////////////////// Upload PHP
    $dossier_img = 'upimg/';
    $fichier_img = basename($_FILES['image']['name']);
    $extension_img = array('.png', '.gif', '.jpg', '.jpeg');
    $info_img = strrchr($_FILES['image']['name'], '.');

    if (in_array($info_img, $extension_img)) {
        if (move_uploaded_file($_FILES['image']['tmp_name'], $dossier_img . $fichier_img)) {
            echo '<div class="alert alert-success">Upload ok ! :-)</div>';
        } else {
            echo '<div class="alert alert-danger"><strong>Attention ! </strong>echec de l\'upload...</div>';
        }
        ///////////////////////////////////////////////// Connexion au MySQL et a la table

        try {
            $db = new PDO('mysql:host=localhost;dbname=voyages','root','');
        } catch (Exception $e) {
            die('Erreur : '. $e->getmessage());
        }
        
        ///////////////////////////////////////////////// Fonction SQL
        
        $sql = 'INSERT INTO voyages VALUES(null, :titre, :contenu, :image)';
   
        //////////////////////////////////////////////// Préparation requete

        $req = $db->prepare($sql);

        $req->execute([
            ':titre' => htmlentities(strip_tags($titre)),
            ':contenu' => htmlentities(strip_tags($contenu)),
            ':image' => $image
        ]);
    } else {
        echo '<div class="alert alert-danger"><strong>Attention ! </strong>vous devez uploader un fichier de type png, gif, jpg, jpeg, txt ou doc...</div>';

    }

}

?>

<link rel="stylesheet" href="./css/bootstrap/4.3.1/bootstrap.min.css" />
<link rel="stylesheet" href="./css/style.css" />
<script src="./js/jquery/3.4.1/jquery.min.js"></script>
<script src="./js/popper/1.15.0/popper.min.js"></script>
<script src="./js/bootstrap/4.3.1/bootstrap.min.js"></script>
<script src="./js/modif/func.js"></script>

<body>

    <div class="container">

        <div class="col">

            <header>

                <!--:::::::::::: Bloc header menu top droite ::::::::::::-->

                <nav class="col-sm navbar">

                    <!--::: Logo :::-->

                    <a class="imgban navbar-brand" href="index.php">Voyages</a>

                    <?php
                    if(isset($_SESSION['logok'])){
                    ?>

                    <!--:::::::::::: Bloc menu top droite ::::::::::::-->

                    <nav class="col-sm-2 navbar">

                        <!--::: Boutton "Déconnexion" :::-->

                        <a href="logout.php" class="btn btn-secondary btn active" role="button"
                            style="background-color:rgba(169, 45, 56, 0.55);border-color:transparent;" name="deco">
                            <p>Déconnexion</p>
                        </a>

                    </nav>

                </nav>

                    <?php
                    } else {
                    ?>

                <nav class="col-sm-2 navbar">

                    <!--::: Boutton "Déconnexion" :::-->

                    <p><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#monCompte"
                        style="background-color:#a92d38; border-color:#a92d38;border-color:transparent;">
                        Connexion
                        </button></p>

                    <!--::: Contenue du bouton "Mon compte" :::-->

                        <div class="modal fade" id="monCompte" tabindex="-1" role="dialog" ria-labelledby="monCompteLabel" aria-hidden="true">

                            <div class="modal-dialog" role="document">

                                <div class="modal-content">

                                    <div class="modal-header">

                                        <h5 class="modal-title" id="monCompteLabel">
                                        Accès a votre compte
                                        </h5>

                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>

                                    </div>

                                    <form action="" class="needs-validation justify-content-center text-center" method="post" novalidate>

                                    <!--::: Nom de compte :::-->

                                        <div class="offset-3 col-6"><br />

                                            <p><label for="ndcompte" style="color:#a92d38;">
                                                    Nom de compte
                                            </label></p>

                                            <input type="text" class="form-control" id="nomdecompte" name ="nomdecompte" placeholder="Votre login" required>


                                            <div class="valid-feedback">
                                                <p>Case complète !</p>
                                            </div>

                                            <div class="invalid-feedback" style="color: red;">
                                                <p>Case incomplète ...</p>
                                            </div>

                                        </div>

                                    <!--::: Mot de passe :::-->

                                    <div class="offset-3 col-6"><br />

                                        <p><label for="motdepasse" style="color:#a92d38;">
                                                Mot de passe
                                            </label></p>

                                        <input type="password" class="form-control" id="motdepasse" name="motdepasse" placeholder="Votre mot de passe"
                                            required />

                                        <div class="valid-feedback">
                                            <p>Case complète !</p>
                                        </div>

                                        <div class="invalid-feedback" style="color: red;">
                                            <p>Case incomplète ...</p>
                                        </div>

                                    </div>

                                    <br />

                                    <input type="checkbox" onclick="affichMDP()"> Afficher/Masquer le mot de passe

                                    <br/>
                                    <br/>

                                    <button class="btn btn-primary" type="submit"
                                    style="background-color:#a92d38; border-color:#a92d38">
                                    Connexion
                                    </button>

                                </form>

                                </div>

                            </div>

                        </nav>

                            <?php
                            }
                            ?>

            </header>

            <!--:::::::::::: Bloc menu principale ::::::::::::-->

            <div class="dropdown row" style="background-color:rgba(169, 45, 56, 0.55);">

                <!--::: Menu "Parcourir" :::-->

                <a class="nav-item nav-link active text-white" href="voyage.php">
                    Parcourir
                </a>

                <!--::: Menu "Ajouter voyage" :::-->
                <?php
                    if(isset($_SESSION['logok'])){
                ?>
                <a class="nav-item nav-link active text-white" href="formvoyage.php">
                    Ajouter voyage
                </a>
                <?php
                }
                ?>
            </div>

        </div>

        <hr />

        <div class="col">

            <!--:::::::::::: Bloc contenue ::::::::::::-->

            <div class="center-block p-3" style="background-color:rgba(169, 45, 56, 0.90); color: white;" class="input-group">

            <form action="" method="post" enctype="multipart/form-data">

                <div class="form-group">
                    <label for="titre">Titre</label>
                    <input type="text" class="form-control form-control-lg" name="titre" id="titre" placeholder="Titre du contenu"/>

                    <br/>

                    <label for="contenu">Contenu</label>
                    <textarea type="text" class="form-control" rows="3" name="contenu" id="contenu" placeholder="Texte du contenu"/></textarea>

                    <br/>

                    <input type="file" class="form-control" name="image" id="image">
                    <input type="hidden" name="MAX_FILE_SIZE" value="100000">

                    <br/>

                    <button type="submit" class="btn btn-primary">Envoyer</button>

                </div>

            </form>

        </div>

    </div>

    <hr />

</div>

    </div>

    <script>
        (function () {
            'use strict';
            window.addEventListener('load', function () {
                var forms = document.getElementsByClassName('needs-validation');
                var validation = Array.prototype.filter.call(forms, function (form) {
                    form.addEventListener('submit', function (event) {
                        if (form.checkValidity() === false) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
            }, false);

        })();
    </script>

<script>
// Add the following code if you want the name of the file appear on select
$(".custom-file-input").on("change", function() {
  var fileName = $(this).val().split("\\").pop();
  $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
});
</script>

</body>