<?php
// Start the session
session_start();

//Verification d'utilisateur connecté
// if ( (empty($_SESSION["user"])) || ($_SESSION["droits"] != "RJ") ) {
//     header('Location: http://ja.de.pau.free.fr');
//     exit();
// }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="refresh" content="900">
        <title>JA de PAU </title>   
        <meta name="description" content="Planning et badge des JA de Pau">
        <meta name="keywords" content="JA, PAU, Badge, Adventiste, Jeunesse">
        <meta name="robots" content="index,follow">
        <meta name="google" content="index"> 
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="designJA.css">
        <script src="inscription.js"></script>
        
    </head>
    <body>
        <div class="container">
            <?php 
            include('entete.html');
            ?>
            <?php 
            include('barreNav.php');
            ?>
            <div class="row">
                <div class="panel ">
                    <div class="panel-heading"><h2>Nouvelle fiche d'animation</h2>
                    <em>Tous les champs sont obligatoires. </em>
                    </div>
                    <!-- TODO : Check validite des champs ! -->
                    <div class="panel-body"><form class="form-horizontal" action="" method="POST">
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="nomA">Nom de l'animation :</label>
                        <div class="col-sm-10">
                            <input type="text" onfocusout="nomSaisi(this)" class="form-control" id="nomA" placeholder="Saisir le nom / titre de l'animation" name="nomA">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="typeAnimation">Type d'animation :</label>
                        <div class="col-sm-10">
                            <label class="checkbox-inline"><input type="checkbox" name="typeA_int" value="interieur">intérieur</label>
                            <label class="checkbox-inline"><input type="checkbox" name="typeA_ext" value="exterieur">extérieur</label>
                            <label class="checkbox-inline"><input type="checkbox" name="typeA_vei" value="veillee">veillée</label>
                            <label class="checkbox-inline"><input type="checkbox" name="typeA_jcr" value="jeuCourt">jeu court</label>
                            <label class="checkbox-inline"><input type="checkbox" name="typeA_jco" value="jeuCoop">jeu coopératif</label>
                            <label class="checkbox-inline"><input type="checkbox" name="typeA_gdj" value="grandJeu">grand jeu</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="trancheAnimation">Tranche d'âge :</label>
                        <div class="col-sm-10">
                            <span class="control-label col-sm-1" for="trancheA_min">minimum  </span>
                            <span class="col-sm-3">
                                <input type="number" onfocusout="nomSaisi(this)" id="trancheA_min" class="form-control"  placeholder="entre 2 et 20 ans" name="trancheA_min" min="2" max="20">
                            </span>
                            <span class="control-label col-sm-1" for="trancheA_max">maximum  </span>
                            <span class="col-sm-3">
                                <input type="number" onfocusout="nomSaisi(this)" id="trancheA_max" class="form-control"  placeholder="entre 5 et 99 ans" name="trancheA_max" min="5" max="99">
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="dureeA">Durée (en minutes):</label>
                        <div class="col-sm-10">
                            <input type="number" onfocusout="nomSaisi(this)" class="form-control" id="dureeA" placeholder="Durée de l'animation en minutes" name="dureeA">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="butA">But du jeu :</label>
                        <div class="col-sm-10">
                            <textarea class="form-control" onfocusout="nomSaisi(this)" rows="3" maxlength="300" id="butA" name="butA" placeholder="But / Objectif du jeu (300 caractères max)"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="regleA">Règles du jeu :</label>
                        <div class="col-sm-10">
                           <textarea class="form-control" onfocusout="nomSaisi(this)" rows="15" id="regleA" name="regleA" placeholder="Description des règles du jeu"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="materielA">Matériel :</label>
                        <div class="col-sm-10">
                            <textarea class="form-control" onfocusout="nomSaisi(this)" rows="5" id="materielA" name="materielA" placeholder="Liste du matériel nécessaire pour le jeu"></textarea>
                        </div>
                    </div>
                    </form></div>
                </div>
            </div>
            <?php 
            include('piedPage.html');
            ?>
        </div>
    </body>
</html> 
