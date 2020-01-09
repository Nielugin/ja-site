<?php
// Start the session
session_start();

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
                    <?php 
                    if (!isset($_GET[idFTA]) ) {
                        header('Location: http://ja.de.pau.free.fr/listeFTA.php');
                    } else {
                        $servername = "sql.free.fr";
                        $username = "ja.de.pau";
                        $password = "Sq7:P@ss";   
                        $dbname = "ja_de_pau";
                        
                        // Connexion à la BDD
                        $db = connecterBDD($servername, $username, $password);
                        mysql_select_db($dbname, $db);
                        mysql_query("SET NAMES 'utf8'");

                        // Récupérer les différentes activités Tisons du futur
                        $sql = "SELECT * FROM FicheTechniqueAnimation WHERE idFTA = ".$_GET[idFTA];
                        $result = mysql_query($sql, $db) or exit(mysql_error() . "<br/>$sql");
                        
                        // Récupère les données s'il y en a
                        if (mysql_num_rows($result) == 1) {
                            $animation = mysql_fetch_assoc($result);
                        } else {
                            // S'il y a plus d'une animation, c'est qu'il y a un problème.
                            // On redirige vers la page de liste des Animations
                            header('Location: http://ja.de.pau.free.fr/listeFTA.php');
                        }
                    ?>
                    <div class="panel-heading"><h1><?php echo $animation['nomActivite']; ?> </h1>
                    </div>
                    <div class="panel-body">
                        <h3>Fiche technique </h3>
                        <div class="row">
                            <div class="col-sm-4"><b>Activité</b> : <?php echo $animation['zoneActivite']; ?></div>
                            <div class="col-sm-4"><b>Durée</b> : <?php echo $animation['dureeActivite']; ?> min</div>
                            <div class="col-sm-4"><b>Date</b> : <?php echo $animation['dateActivite']; ?></div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12"><b>Public visé</b> : <?php echo str_replace(",",", ",$animation['publicVise']); ?></div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12"><b>Raison d'être de l'activité</b> : <?php echo $animation['raisonActivite']; ?></div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12"><b>Texte de méditation</b> : <?php echo $animation['texteMedit']; ?></div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12"><b>Objectifs visés</b> : <?php echo $animation['objectifsVises']; ?></div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12"><b>Thème / trame</b> : <?php echo $animation['themeActivite']; ?></div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12"><b>Type d'activité</b> : <?php echo $animation['typeActivite']; ?></div>
                        </div>
                        <div class="row">
                            <div class="col-sm-8"><b>Nombre d'animateurs nécessaires</b> : <?php echo $animation['nombreAnims']; ?></div>
                            <div class="col-sm-4"><b>Déplacement à prévoir</b> : <?php
                            if ($animation['deplacement']) echo "oui"; else echo "non"; ?></div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12"><b>Fonctionnement en </b> : <?php echo $animation['fonctionnementEn']; ?></div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12"><b>Constitution des équipes </b> : <?php echo $animation['constitutionEquipe']; ?></div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4"><b>Lieu de début d'activité</b> : <?php echo $animation['lieuDebutActivite']; ?></div>
                            <div class="col-sm-4"><b>Lieu de fin d'activité</b> : <?php echo $animation['lieuFinActivite']; ?></div>
                            <div class="col-sm-4"><b>Type de fin </b> : <?php echo $animation['typeDeFin']; ?></div>
                        </div>
                        <h3>Trame générale </h3>
                        <p><?php echo nl2br($animation['trameGenerale']); ?></p>
                        <h3>Déroulement de l'activité</h3>
                        <p><?php echo nl2br($animation['deroulementActivite']); ?></p>
                        <?php 
                        if ($animation['docPJ'] != "") {
                        ?>
                            <br><a target="_blank" rel="noopener noreferrer" href="<?php echo $animation['docPJ']; ?>"> <span class="glyphicon glyphicon-download"></span> Document complémentaire </a>
                        <?
                        }
                        ?>
                        <h3>Matériel</h3>
                        <p><?php echo nl2br($animation['materiel']); ?></p>
                        <a href="listeFTA.php"><span class="glyphicon glyphicon-menu-left"></span> Retour à la liste d'animation </a>
                    </div>
                    <?php 
                    }
                    ?>
                </div>
            </div>
            <?php 
            include('piedPage.html');
            ?>
        </div>
    </body>
</html> 
