<?php
// Start the session
session_start();

//Verification d'utilisateur connecté
if ( (empty($_SESSION["user"])) || (!in_array("WA",explode(',',$_SESSION["droits"]))) ) {
    header('Location: http://ja.de.pau.free.fr');
    exit();
}
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
                    <div class="panel-heading"><h1>Nouvelle fiche technique d'animation</h1>
                    </div>
                    <!-- TODO : Check validite des champs ! -->
                    <div class="panel-body"><form class="form-horizontal" action="listeFTA.php" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="nomActivite">Nom de l'animation :</label>
                        <div class="col-sm-10">
                            <input type="text" onfocusout="nomSaisi(this)" class="form-control" id="nomActivite" placeholder="Saisir le nom / titre de l'animation" name="nomActivite">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="dureeActivite">Durée (en minutes):</label>
                        <div class="col-sm-10">
                            <input type="number" onfocusout="nomSaisi(this)" class="form-control" id="dureeActivite" placeholder="Durée de l'animation en minutes" name="dureeActivite">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="zoneActivite">Activité :</label>
                        <div class="col-sm-10">
                            <label class="radio-inline"><input type="radio" name="zoneActivite" value="Locale">Locale</label>
                            <label class="radio-inline"><input type="radio" name="zoneActivite" value="Regionale">Régionale</label>
                            <label class="radio-inline"><input type="radio" name="zoneActivite" value="Federale">Fédérale</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="dateActivite">Date:</label>
                        <div class="col-sm-10">
                            <input type="date" onfocusout="nomSaisi(this)" class="form-control" id="dateActivite" name="dateActivite">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="publicVise">Public visé :</label>
                        <div class="col-sm-10">
                            <label class="checkbox-inline"><input type="checkbox" name="bourgeons" value="Bourgeons">Bourgeons</label>
                            <label class="checkbox-inline"><input type="checkbox" name="tisons" value="Tisons">Tisons</label>
                            <label class="checkbox-inline"><input type="checkbox" name="explos" value="Explos">Explos</label>
                            <label class="checkbox-inline"><input type="checkbox" name="compagnons" value="Compagnons">Compagnons</label>
                            <label class="checkbox-inline"><input type="checkbox" name="ainés" value="Ainés">Ainés</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="raisonActivite">Raison d’être de l’activité :</label>
                        <div class="col-sm-10">
                            <textarea class="form-control" onfocusout="nomSaisi(this)" rows="3" maxlength="500" id="raisonActivite" name="raisonActivite" placeholder="Raison d'être de l'activité (500 caractères max)"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="texteMedit">Texte de méditation :</label>
                        <div class="col-sm-10">
                            <textarea class="form-control" onfocusout="nomSaisi(this)" rows="2" maxlength="100" id="texteMedit" name="texteMedit" placeholder="Texte de la méditation (100 caractères max)"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="objectifsVises">Objectifs visés :</label>
                        <div class="col-sm-10">
                            <textarea class="form-control" onfocusout="nomSaisi(this)" rows="3" maxlength="500" id="objectifsVises" name="objectifsVises" placeholder="Objectifs visés (500 caractères max)"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="themeActivite">Trame / Thème :</label>
                        <div class="col-sm-10">
                            <textarea class="form-control" onfocusout="nomSaisi(this)" rows="2" maxlength="300" id="themeActivite" name="themeActivite" placeholder="Trame ou thème de l'activité (300 caractères max)"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="typeActivite">Type d'activité :</label>
                        <div class="col-sm-10">
                            <textarea class="form-control" onfocusout="nomSaisi(this)" rows="2" maxlength="300" id="typeActivite" name="typeActivite" placeholder="Type d'activité (300 caractères max)"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="nombreAnims">Nombre d'animateurs nécessaires :</label>
                        <div class="col-sm-10">
                            <textarea class="form-control" onfocusout="nomSaisi(this)" rows="2" maxlength="500" id="nombreAnims" name="nombreAnims" placeholder="Nombre d'animateurs nécessaires (500 caractères max)"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="deplacement">Déplacement à prévoir :</label>
                        <div class="col-sm-10">
                            <label class="radio-inline"><input type="radio" name="deplacement" value="oui"> Oui</label>
                            <label class="radio-inline"><input type="radio" name="deplacement" value="non"> Non</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="fonctionnementEn">Fonctionnement en :</label>
                        <div class="col-sm-10">
                            <label class="radio-inline"><input type="radio" name="fonctionnementEn" value="Individuel"> Individuel</label>
                            <label class="radio-inline"><input type="radio" name="fonctionnementEn" value="Equipes"> Equipes</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="constitutionEquipe">Constitution des équipes :</label>
                        <div class="col-sm-10">
                            <label class="radio-inline"><input type="radio" name="constitutionEquipe" value="individuel"> Inscriptions individuelles</label>
                            <label class="radio-inline"><input type="radio" name="constitutionEquipe" value="gps"> GPS</label>
                            <label class="radio-inline"><input type="radio" name="constitutionEquipe" value="tirageSort"> Tirage au sort</label>
                            <label class="radio-inline"><input type="radio" name="constitutionEquipe" value="choixResp"> Choix du responsable</label>
                            <label class="radio-inline"><input type="radio" name="constitutionEquipe" value="autre"> Autre : <input type="text" name="constitutionAutre" disabled/></label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="lieuDebutActivite">Lieu du début de l'activité :</label>
                        <div class="col-sm-10">
                            <label class="radio-inline"><input type="radio" name="lieuDebutActivite" value="Eglise"> Eglise </label>
                            <label class="radio-inline"><input type="radio" name="lieuDebutActivite" value="autre"> Autre : <input type="text" name="lieuDebutAutre" disabled/></label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="lieuFinActivite">Lieu de fin de l'activité :</label>
                        <div class="col-sm-10">
                            <label class="radio-inline"><input type="radio" name="lieuFinActivite" value="Eglise"> Eglise </label>
                            <label class="radio-inline"><input type="radio" name="lieuFinActivite" value="autre"> Autre : <input type="text" name="lieuFinAutre" disabled/></label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="typeDeFin">Type de fin :</label>
                        <div class="col-sm-10">
                            <label class="radio-inline"><input type="radio" name="typeDeFin" value="prixEquipe"> Prix par équipe</label>
                            <label class="radio-inline"><input type="radio" name="typeDeFin" value="recompCollective"> Récompense collective</label>
                            <label class="radio-inline"><input type="radio" name="typeDeFin" value="classement"> Classement</label>
                            <label class="radio-inline"><input type="radio" name="typeDeFin" value="autre"> Autre : <input type="text" name="finAutre" disabled/></label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="trameGenerale">Trame générale :</label>
                        <div class="col-sm-10">
                            <textarea class="form-control" onfocusout="nomSaisi(this)" rows="10" maxlength="1000" id="trameGenerale" name="trameGenerale" placeholder="But / Objectif du jeu (1000 caractères max)"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="deroulementActivite">Déroulement de l’activité :</label>
                        <div class="col-sm-10">
                            <textarea class="form-control" onfocusout="nomSaisi(this)" rows="20" maxlength="20000" id="deroulementActivite" name="deroulementActivite" placeholder="But / Objectif du jeu (20000 caractères max)"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="materiel">Matériel :</label>
                        <div class="col-sm-10">
                            <textarea class="form-control" onfocusout="nomSaisi(this)" rows="5" maxlength="500"  id="materiel" name="materiel" placeholder="Liste du matériel nécessaire pour le jeu"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="fileToUploadDocumentJeu">Document complémentaire (.jpg, .pdf, .doc ou .zip) :</label>
                        <div class="col-sm-10">
                            <input id="fileToUploadDocumentJeu" type="file" name="fileToUploadDocumentJeu" accept=".jpg,.pdf,.doc,.zip">
                        </div>
                    </div>
                    <input class="btn btn-success btn-block" type='submit' name='valider' value='Valider'>
                    </form></div>
                </div>
            </div>
            <?php 
            include('piedPage.html');
            ?>
        </div>
    </body>
</html> 
