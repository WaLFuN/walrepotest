<?php

if (isset($_FILES['image'])) { 
     $dossier_cible = 'upimg/';
     $fichier_cible = basename($_FILES['image']['name']);

     if(move_uploaded_file($_FILES['image']['tmp_name'], $dossier_cible . $fichier_cible)) {
          echo 'Upload effectué avec succès !';
     } else {
          echo 'Echec de l\'upload !';
     }
}

?>