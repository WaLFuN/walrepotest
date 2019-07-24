<?php

///////////////////////////////////////////////// Démarre la session 

session_start();

///////////////////////////////////////////////// Connexion au MySQL

try {
   $db = new PDO('mysql:host=localhost;dbname=voyages','root',''); // connexion a la table "voyages" avec le login root (sans mot de passe)
} catch (Exception $e) {
   die('Erreur : '. $e->getmessage()); // si il y a un problème de connexion, ça affichera pourquoi
}

///////////////////////////////////////////////// connexion a la table

$sql = 'SELECT * FROM voyages'; // on choisi tout de la table "voyages"

///////////////////////////////////////////////// Préparation injection

$req = $db->prepare($sql); // on initialise la connexion a la base SQL

$req->execute(); // on execute le sql

?>

<link rel="stylesheet" href="./css/bootstrap/4.3.1/bootstrap.min.css" />
<link rel="stylesheet" href="./css/style.css" />
<script type="text/javascript" src="http://livejs.com/live.js"></script>
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
                    if(isset($_SESSION['logok'])){ // on ouvre la balise PHP qui va bloqué l'affichage du menu "ajouter voyage)
                    ?>

                    <!--:::::::::::: Bloc menu top droite ::::::::::::-->

                    <nav class="col-sm-2 navbar">

                        <!--::: Boutton "Déconnexion" :::-->

                        <a href="logout.php" class="btn btn-secondary btn active" role="button"
                            style="background-color:rgba(45, 50, 169, 0.55); border-color:transparent;" name="deco">
                            <p>Déconnexion</p>
                        </a>

                    </nav>

                </nav>

                    <?php
                    } else { // on ferme la balise PHP
                    ?>

                <nav class="col-sm-2 navbar">

                    <!--::: Boutton "Connexion" :::-->

                    <p><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#monCompte"
                        style="background-color:rgba(45, 50, 169, 0.55);border-color:transparent;">
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

            <div class="dropdown row" style="background-color: rgba(45, 50, 169, 0.55);">

                <!--::: Menu "Parcourir" :::-->

                <a class="nav-item nav-link active text-white" href="#">
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

        <hr />

            <!--:::::::::::: Bloc contenue ::::::::::::-->

            <?php

            while ($voyagelist = $req->fetch(PDO::FETCH_ASSOC)) { // on va lancer le fetch qui va récupérer les infos de la base via une boucle while (qui va donc afficher toutes les 
            // requettes effectué via le formulaire d'envoi en créant l'objet "voyagelist" qui sera utilisé pour récupérer les colonnes, tout en utilisant bootstrap et du html pour mettre en forme la page)

            echo utf8_encode(
                '<div class="article">'
                .
                '<div class="panel panel-primary">'
                .
                '<div class="panel-heading col-12">'
                .
                '<center><h3 class="panel-title">'
                .
                $voyagelist['titre'] // on affiche les résultats de la colonne "titre"
                .
                '</h3></center><br/>'
                .
                '<div class="panel-body row col-12"><p class="col-8">'
                .
                $voyagelist['contenu'] // on affiche les résultats de la colonne "contenu"
                .
                '</p>'
                .
                '<img class="imgart col-4 " src=upimg/'
                .
                $voyagelist['image'] // on affiche les résultats de la colonne "image"
                .
                '></img>'
                .
                '</div>'
                .
                '</div>'
                .
                '</div>'
                .
                '</div>');

            // echo utf8_encode(('<article class="article"><div><h2 class="titleA">' . $article['titre'] . '</h2><p>' . $article['contenu'].'</p></div><div><img class="img" src=upimg/'.$article['image'].'></img></div></article>'));
            }
            ?>

    </div>
            <!-- <hr /> -->

    </div>

    <script>
        (function () { // script de check'in des "required"
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

</body>