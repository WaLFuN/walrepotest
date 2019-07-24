<?php

///////////////////////////////////////////////// Démarre la session 

session_start();

///////////////////////////////////////////////// Fonction de déconnexion

if (isset($_GET['deconnexion']) && $_GET['deconnexion']==1) {
    session_destroy(); // script de déconnexion de la session actuelle
    header("Location : index.php?fail");
    echo '<div class="alert alert-warning"><strong>Michel ... </strong>il faut te connecté avant d\'accéder a cette page ! :-)</div>';
}

///////////////////////////////////////////////// _GET anti non-connecté

if (isset($_GET['deco'])) {
    echo '<div class="alert alert-warning"><strong>Michel ... </strong>il faut te connecté avant d\'accéder a cette page ! :-)</div>';
}

///////////////////////////////////////////////// _GET notification connexion

if (isset($_GET['connecter'])) {
    echo '<div class="alert alert-success"><strong>Woallay ... </strong>Tu es bel est bien connectay ! :-)</div>';
}

///////////////////////////////////////////////// Connexion au MySQL

try {
   $db = new PDO('mysql:host=localhost;dbname=voyages','root',''); // connexion a la table "voyages" avec le login root (sans mot de passe)
}

catch (Exception $e) {
   die('Erreur : '. $e->getmessage()); // si il y a un problème de connexion, ça affichera pourquoi
}

$sql = 'SELECT * from utilisateurs WHERE nomdecompte=:nomdecompte'; // via la table utilisateur, on va recherche la colonne "nomdecompte" !

if(isset($_POST['nomdecompte']) && isset($_POST['motdepasse'])) { // créa du isset et mise en place du get (isset = si il existe déjà)
   $nomdecompte = $_POST['nomdecompte']; // on dit que $mail = get du 'mail'
   $motdepasse = $_POST['motdepasse']; // on dit que $pwd = get du 'pwd'

///////////////////////////////////////////////// Préparation SQL

$req = $db->prepare($sql); // on prépare l'injection SQL (protège des failles d'injection)

$req->execute([ // on exécute le SQL
    ':nomdecompte' => htmlentities(strip_tags($nomdecompte))
]);

///////////////////////////////////////////////// Fetch

$user = $req->fetch(PDO::FETCH_ASSOC);

///////////////////////////////////////////////// Script de connexion

if ($motdepasse == $user['motdepasse']) {
    $_SESSION['logok'] = 1; // si on est bien connecté, ça va générer un objet "logok" qui sera sur "1" qui nous permettra de savoir si l'on est connecté ou non
    header("location: index.php?connecter"); // si le login est bon, redirection sur index.php avec le get "connecter" (auquel on a fais un message de bienvenue plus haut !)
} else {
    echo '<div class="alert alert-danger"><strong>Attention ! </strong>mail ou mot de passe erroné ...</div>'; // si pas connecté : msg d'erreur
   }
}

?>

<!--:::::::::::: Chargement des scripts ::::::::::::-->

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
                    if(isset($_SESSION['logok'])){ // on ouvre la balise PHP qui va bloqué l'affichage du menu "ajouter voyage)
                    ?>

                    <!--:::::::::::: Bloc menu top droite ::::::::::::-->

                    <nav class="col-sm-2 navbar">

                        <!--::: Boutton "Déconnexion" :::-->

                        <a href="logout.php" class="btn btn-secondary btn active" role="button"
                            style="background-color:rgba(45, 50, 169, 0.55);border-color:transparent;" name="deco">
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

            <div class="dropdown row" style="background-color:rgba(45, 50, 169, 0.55);">

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

            <div class="center-block p-3" style="background-color:rgba(45, 50, 169, 0.90); color: white;"><p>
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam vitae augue pulvinar, pharetra nulla
                id, egestas dolor. Suspendisse euismod mi magna, eu tempor sem mattis at. Ut eget lectus at sapien
                porttitor luctus. Morbi quis facilisis ante, a rutrum ipsum. Vivamus et magna ante. Donec in est arcu.
                Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Ut a feugiat
                ipsum. Sed convallis felis ut blandit faucibus. Etiam porttitor sed ligula sed venenatis. Fusce lacinia
                orci luctus, scelerisque nibh ac, bibendum eros. Quisque vel urna dictum, rutrum dolor ac, feugiat eros.
                Aliquam tristique consequat nibh, et facilisis nunc rutrum sed. Sed eu dignissim magna. Phasellus
                suscipit varius nibh, a dapibus risus dapibus sed.

                Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Sed sed tellus
                dolor. Nullam et viverra velit, nec vulputate massa. Orci varius natoque penatibus et magnis dis
                parturient montes, nascetur ridiculus mus. Cras egestas diam ut egestas porta. Cras sed semper justo.
                Integer ornare enim vitae orci vulputate, nec tempor metus finibus. Fusce tempus vehicula ligula ac
                facilisis. Maecenas gravida pulvinar nisl, vitae rhoncus lectus ultricies id. Fusce interdum id massa at
                aliquam. Duis molestie urna eros, sed aliquet ex sodales eget. Cras et ante ut quam tincidunt imperdiet
                non et nunc. Integer vitae elit in mauris efficitur bibendum vel nec neque. Proin vel lobortis odio.
                Donec viverra rhoncus ante, eget maximus erat facilisis eget.

                Cras augue enim, sagittis eu placerat et, faucibus quis est. Phasellus tempor nibh nulla, vitae iaculis
                mauris rhoncus vitae. Ut at lectus ac magna bibendum consequat. Nunc fringilla fermentum vestibulum.
                Suspendisse diam nulla, tempor at urna quis, rutrum euismod ligula. Nam fermentum ultrices porttitor.
                Proin nec tortor sed ipsum egestas pretium. Praesent tempus libero vel varius varius. Quisque vel
                hendrerit libero. Donec pretium risus laoreet justo imperdiet, et varius turpis facilisis. Vivamus a
                nulla at nisi consectetur ornare.

                Praesent porttitor efficitur congue. Vestibulum consequat metus vel mauris elementum malesuada. Vivamus
                eros nisi, iaculis vel elit in, fermentum fringilla purus. Duis tincidunt mauris ut mi aliquam, at
                bibendum lacus rhoncus. Cras dapibus dui enim, vitae hendrerit dolor placerat a. Aenean in venenatis ex.
                Suspendisse nulla metus, vehicula vehicula sem vel, tempus scelerisque ligula. Etiam facilisis velit non
                ex maximus, ut placerat purus hendrerit. Maecenas vitae lorem dignissim, interdum neque quis, placerat
                nisi. In dolor nibh, aliquam vel maximus non, iaculis et nulla.

                Curabitur eros neque, maximus in ipsum in, varius rhoncus mauris. Morbi a dictum ligula. Duis non enim
                nisi. Sed sagittis eget nulla ac volutpat. Etiam egestas et lectus eu vulputate. Integer ornare, quam id
                condimentum molestie, magna tortor blandit leo, a ultricies risus nibh in metus. Sed eget gravida risus.
                Integer sed accumsan nulla, sed imperdiet ante. Praesent cursus malesuada elementum.
            </p></div>

            <hr />

        </div>

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
