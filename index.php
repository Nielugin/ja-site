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
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="designJA.css">
        
    </head>
    <body>
        <div class="container">
            <?php 
            include('entete.html');
            ?>
            <?php 
            include('barreNav.php');
            
            $servername = "sql.free.fr";
            $username = "ja.de.pau";
            $password = "Sq7:P@ss";   
            $dbname = "ja_de_pau";
            
            ?>
            
            <div class="row">
								
                <div class="col-sm-4">
                
                <?php
                //cas du changement d'images
                if (!empty($_POST)) {
                    // Cas de l'image fédérale
                    if (isset($_POST['decoy'])) {
                        if ($_FILES['fileToUploadFederal']['error']  > 0 ) {
                            echo 'Erreur:'.$_FILES['fileToUploadFederal']['error'].'<br/>';
                        } else {
                            $res = move_uploaded_file($_FILES['fileToUploadFederal']['tmp_name'], 
                                './images/Federales.jpg');
                        }
                    } elseif(isset($_POST['decoyL'])) {
                        if ($_FILES['fileToUploadLocal']['error']  > 0 ) {
                            echo 'Erreur:'.$_FILES['fileToUploadLocal']['error'].'<br/>';
                        } else {
                            $res = move_uploaded_file($_FILES['fileToUploadLocal']['tmp_name'], 
                                './images/Locales.jpg');
                        }
                    }
                }
                ?>
                
                    <h3> Informations fédérales </h3>
                    <!--<img class="img-responsive" src="images/AfficheJAinDepth2017.jpg" alt="JA in Depth 2017"/>-->
                    <img id="img-federale" class="img-responsive" src="./images/Federales.jpg" alt="Informations Fédérales"/>
                    <script>
                       document.getElementById("img-federale").src += "?"+new Date().getTime();
                    </script>
                    <?php 
                        // si la personne connectée est responsable JA
                        if ((!empty($_SESSION["user"])) && (in_array("RJ",explode(',',$_SESSION["droits"])))) {
                    ?>
                    <div class="panel panel-danger">
                        <div class="panel-heading">Changer l'image</div>
                        <div class="panel-body">
                            <form action="index.php" method="POST" enctype="multipart/form-data">
                                <div class="form-group">
                                    <input id="fileToUploadFederal" type="file" name="fileToUploadFederal" accept=".jpg">
                                    <input type="hidden" name="decoy" value="decoy" >
                                </div>
                                <input type="submit">
                            </form>
                        </div>
                    </div>
                    <?php
                    }
                    ?>
                </div>
				
                <div class="col-sm-4">
                    <h3> Informations locales </h3>
                    <img id="img-locale" class="img-responsive" src="images/Locales.jpg" alt="Informations Locales"/>
                    <script>
                       document.getElementById("img-locale").src += "?"+new Date().getTime();
                    </script>
                    <?php 
                        // si la personne connectée est responsable JA
                        if ((!empty($_SESSION["user"])) && (in_array("RJ",explode(',',$_SESSION["droits"])))) {
                    ?>
                    <div class="panel panel-danger">
                        <div class="panel-heading">Changer l'image</div>
                        <div class="panel-body">
                            <form action="index.php" method="POST" enctype="multipart/form-data">
                                <div class="form-group">
                                    <input id="fileToUploadLocal" type="file" name="fileToUploadLocal" accept=".jpg">
                                    <input type="hidden" name="decoyL" value="decoyL" >
                                </div>
                                <input type="submit">
                            </form>
                        </div>
                    </div>
                    <?php
                    }
                    ?>
                </div>
                
				
                <div class="col-sm-4">
				<h3>Prochaines activités Tisons</h3>
                
                                <?php
// Connexion à la BDD
$db = connecterBDD($servername, $username, $password);
mysql_select_db($dbname, $db);
mysql_query("SET NAMES 'utf8'");

// Récupérer les différentes activités Tisons du futur
$sql = "SELECT * FROM ActiviteJA NATURAL JOIN SectionJA WHERE libelle='tison' AND dateSamedi >= cast(now() as date) ORDER BY dateSamedi LIMIT 3";
$result = mysql_query($sql, $db) or exit(mysql_error() . "<br/>$sql");

// Creation de l'activite et définition du style par défaut des dates
$activiteJA = '<ul class="list-group">';

// Afficher les données s'il y en a
if (mysql_num_rows($result) > 0) {
    // Affichage des résultats
    while($row = mysql_fetch_assoc($result)) {
        // Cas de la Relâche :
        if ($row["descCourt"] == "Relâche") {
			$activiteJA = $activiteJA.'<li class="list-group-item list-group-item-default"><b>'.transformerDate($row["dateSamedi"]).'</b> -- <em>'.$row["descCourt"].'</em></li>';
        } else {
			$activiteJA = $activiteJA.'<li class="list-group-item list-group-item-success"><b>'.transformerDate($row["dateSamedi"]).'</b> -- '.$row["descCourt"].'</li>';
        }
    }
}
$activiteJA = $activiteJA.'</ul>';
echo $activiteJA;


deconnecterBDD($db);
?>
<h3>Prochaines activités Explos </h3>
                
                                <?php
// Connexion à la BDD
$db = connecterBDD($servername, $username, $password);
mysql_select_db($dbname, $db);
mysql_query("SET NAMES 'utf8'");

// Récupérer les différentes activités Tisons du futur
$sql = "SELECT * FROM ActiviteJA NATURAL JOIN SectionJA WHERE libelle='explorateur' AND dateSamedi >= cast(now() as date) ORDER BY dateSamedi LIMIT 3";
$result = mysql_query($sql, $db) or exit(mysql_error() . "<br/>$sql");

// Creation de l'activite et définition du style par défaut des dates
$activiteJA = '<ul class="list-group">';

// Afficher les données s'il y en a
if (mysql_num_rows($result) > 0) {
    // Affichage des résultats
    while($row = mysql_fetch_assoc($result)) {
        // Cas de la Relâche :
        if ($row["descCourt"] == "Relâche") {
			$activiteJA = $activiteJA.'<li class="list-group-item list-group-item-default"><b>'.transformerDate($row["dateSamedi"]).'</b> -- <em>'.$row["descCourt"].'</em></li>';
        } else {
			$activiteJA = $activiteJA.'<li class="list-group-item list-group-item-info"><b>'.transformerDate($row["dateSamedi"]).'</b> -- '.$row["descCourt"].'</li>';
        }
    }
}
$activiteJA = $activiteJA.'</ul>';
echo $activiteJA;


deconnecterBDD($db);
?>
<h3>Prochaines activités Compagnons</h3>
                
                                <?php
// Connexion à la BDD
$db = connecterBDD($servername, $username, $password);
mysql_select_db($dbname, $db);
mysql_query("SET NAMES 'utf8'");

// Récupérer les différentes activités Tisons du futur
$sql = "SELECT * FROM ActiviteJA NATURAL JOIN SectionJA WHERE libelle='compagnon' AND dateSamedi >= cast(now() as date) ORDER BY dateSamedi LIMIT 3";
$result = mysql_query($sql, $db) or exit(mysql_error() . "<br/>$sql");

// Creation de l'activite et définition du style par défaut des dates
$activiteJA = '<ul class="list-group">';

// Afficher les données s'il y en a
if (mysql_num_rows($result) > 0) {
    // Affichage des résultats
    while($row = mysql_fetch_assoc($result)) {
        // Cas de la Relâche :
        if ($row["descCourt"] == "Relâche") {
			$activiteJA = $activiteJA.'<li class="list-group-item list-group-item-default"><b>'.transformerDate($row["dateSamedi"]).'</b> -- <em>'.$row["descCourt"].'</em></li>';
        } else {
			$activiteJA = $activiteJA.'<li class="list-group-item list-group-item-warning"><b>'.transformerDate($row["dateSamedi"]).'</b> -- '.$row["descCourt"].'</li>';
        }
    }
}
$activiteJA = $activiteJA.'</ul>';
echo $activiteJA;


deconnecterBDD($db);
?>
     
	 <p><a href="planning.php">Plus de dates et de détails ... </a></p>
                </div>
            
			</div>
            <?php 
            include('piedPage.html');
            ?>
        </div>

    </body>
</html> 
