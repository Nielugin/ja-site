<?php
// Start the session
session_start();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html lang="fr">
    <head>
        <meta http-equiv="refresh" content="900">
        <title>JA de PAU </title>   
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="designJA.css">
        <script>
        function accordeon(idToOpen) {
                var i;
                // Element vers lequel on veut aller dans l'accordeon
                var pAccTo = document.getElementById(idToOpen);
                // Element de l'accordeon actuellement ouvert
                var pAccFrom = document.getElementsByClassName("in")[0];
                // Si les deux éléments sont différents, on "ajoute" la class "in" 
                // dans celui vers lequel on veut aller (pAccIn), et on l'enlève de celui dans 
                // lequel il était (pAccFrom)
                if (pAccFrom != pAccTo) {
                        pAccFrom.className = "panel-collapse collapse";
                        pAccTo.className = "panel-collapse collapse in";
                }
                // On fait positionner la fenêtre à l'endroit où l'accordéon est ouvert
                window.location.hash = '#'+idToOpen;
        }
        
        </script>
    </head>
    <body>

<?php
$servername = "sql.free.fr";
$username = "ja.de.pau";
$password = "Sq7:P@ss";   
$dbname = "ja_de_pau";
?>
	
        <div class="container">
            <?php 
            include('entete.html');
            ?>
            <?php 
            include('barreNav.php');
            ?>
            <div class="row"> 
<div class="col-sm-6">
<h2>Badges Tisons</h2> 
				 <?php 			
// Connexion à la BDD
$db = connecterBDD($servername, $username, $password);
mysql_select_db($dbname, $db);
mysql_query("SET NAMES 'utf8'");

// Récupérer les Badges
$sql = "SELECT * FROM Badge WHERE typeBadge = 'Engagement' AND idSection=1";
$result = mysql_query($sql, $db) or exit(mysql_error() . "<br/>$sql");

		// Afficher les données s'il y en a
if (mysql_num_rows($result) > 0) {
	$row = mysql_fetch_assoc($result);
	$panelAccordeon = '<div class="panel panel-default"> <div class="panel-heading"> <h4 class="panel-title">';
	$panelAccordeon = $panelAccordeon.'<a data-toggle="collapse" data-parent="#accordion" href="#collapseE1">'.$row['libelle'].'</a> </h4> </div>';
    $panelAccordeon = $panelAccordeon.'<div id="collapseE1" class="panel-collapse collapse"><div class="panel-body">';
	$panelAccordeon = $panelAccordeon.'<img src="'.$row['logo'].'" alt="badge engagement" style="float:right; width:100px"/>';
	$panelAccordeon = $panelAccordeon.$row['description'].'</div> </div> </div> ';
	echo $panelAccordeon;
}
?>
	<h3>Qualifications </h3>
<?php 			

// Récupérer les Badges
$sql = "SELECT * FROM Badge WHERE typeBadge = 'Qualification' AND idSection=1 ORDER BY idBadge";
$result = mysql_query($sql, $db) or exit(mysql_error() . "<br/>$sql");

		// Afficher les données s'il y en a
if (mysql_num_rows($result) > 0) {
	echo '<div class="panel panel-default"> ';
	while($row = mysql_fetch_assoc($result)) {
		$panelAccordeon = '<div class="panel-heading"> <h4 class="panel-title">';
		$panelAccordeon = $panelAccordeon.'<a data-toggle="collapse" data-parent="#accordion" href="#collapseQ'.$row['idBadge'].'">'.$row['libelle'].'</a> </h4> </div>';
		$panelAccordeon = $panelAccordeon.'<div id="collapseQ'.$row['idBadge'].'" class="panel-collapse collapse"><div class="panel-body">';
		$panelAccordeon = $panelAccordeon.'<img src="'.$row['logo'].'" alt="badge engagement" style="float:right; width:100px"/>';
		$panelAccordeon = $panelAccordeon.$row['description'].'</div> </div> ';
		echo $panelAccordeon;
	}
	echo ' </div>';
}
?>  
				<h3>Spécifications </h3>
<?php
// Récupérer les Badges
$sql1 = "SELECT DISTINCT cb.theme, cb.idCategorie FROM CategorieBadge cb, Badge b WHERE cb.idCategorie = b.idCategorie AND b.idSection=1 ORDER BY idCategorie";
$result1 = mysql_query($sql1, $db) or exit(mysql_error() . "<br/>$sql1");

// Afficher les données s'il y en a
if (mysql_num_rows($result1) > 0) {
    while($row1 = mysql_fetch_assoc($result1)) {
        echo '<h4>'.$row1['theme'].'</h4>';

        // Récupérer les Badges
        $sql = "SELECT * FROM Badge WHERE typeBadge = 'Spécialisation' AND idSection=1 AND idCategorie=".$row1['idCategorie']." ORDER BY idBadge";
        $result = mysql_query($sql, $db) or exit(mysql_error() . "<br/>$sql");

                        // Afficher les données s'il y en a
        if (mysql_num_rows($result) > 0) {
                echo '<div class="panel panel-default"> ';
                while($row = mysql_fetch_assoc($result)) {
                        $panelAccordeon = '<div class="panel-heading"> <h4 class="panel-title">';
                        $panelAccordeon = $panelAccordeon.'<a data-toggle="collapse" data-parent="#accordion" href="#collapseS'.$row['idBadge'].'">'.$row['libelle'].'</a> </h4> </div>';
                        $panelAccordeon = $panelAccordeon.'<div id="collapseS'.$row['idBadge'].'" class="panel-collapse collapse"><div class="panel-body">';
                        $panelAccordeon = $panelAccordeon.'<img src="'.$row['logo'].'" alt="badge engagement" style="float:right; width:100px"/>';
                        $panelAccordeon = $panelAccordeon.$row['description'].'</div> </div> ';
                        echo $panelAccordeon;
                }
                echo ' </div>';
        }
    } // par specialisation : while
} // par specialisation : if
deconnecterBDD($db);
?>  
				
</div>
<div class="col-sm-6">

                <h2>Badges Explos</h2> 
<?php 			
// Connexion à la BDD
$db = connecterBDD($servername, $username, $password);
mysql_select_db($dbname, $db);
mysql_query("SET NAMES 'utf8'");

// Récupérer les Badges
$sql = "SELECT * FROM Badge WHERE typeBadge = 'Engagement' AND idSection=2";
$result = mysql_query($sql, $db) or exit(mysql_error() . "<br/>$sql");

		// Afficher les données s'il y en a
if (mysql_num_rows($result) > 0) {
	$row = mysql_fetch_assoc($result);
	$panelAccordeon = '<div class="panel panel-default"> <div class="panel-heading"> <h4 class="panel-title">';
	$panelAccordeon = $panelAccordeon.'<a data-toggle="collapse" data-parent="#accordion" href="#collapseE2">'.$row['libelle'].'</a> </h4> </div>';
    $panelAccordeon = $panelAccordeon.'<div id="collapseE2" class="panel-collapse collapse"><div class="panel-body">';
	$panelAccordeon = $panelAccordeon.'<img src="'.$row['logo'].'" alt="badge engagement" style="float:right; width:100px"/>';
	$panelAccordeon = $panelAccordeon.$row['description'].'</div> </div> </div> ';
	echo $panelAccordeon;
}
?>
				<h3>Qualifications </h3>
<?php 			

// Récupérer les Badges
$sql = "SELECT * FROM Badge WHERE typeBadge = 'Qualification' AND idSection=2 ORDER BY idBadge";
$result = mysql_query($sql, $db) or exit(mysql_error() . "<br/>$sql");

		// Afficher les données s'il y en a
if (mysql_num_rows($result) > 0) {
	echo '<div class="panel panel-default"> ';
	while($row = mysql_fetch_assoc($result)) {
		$panelAccordeon = '<div class="panel-heading"> <h4 class="panel-title">';
		$panelAccordeon = $panelAccordeon.'<a data-toggle="collapse" data-parent="#accordion" href="#collapseQ'.$row['idBadge'].'">'.$row['libelle'].'</a> </h4> </div>';
		$panelAccordeon = $panelAccordeon.'<div id="collapseQ'.$row['idBadge'].'" class="panel-collapse collapse"><div class="panel-body">';
		$panelAccordeon = $panelAccordeon.'<img src="'.$row['logo'].'" alt="badge engagement" style="float:right; width:100px"/>';
		$panelAccordeon = $panelAccordeon.$row['description'].'</div> </div> ';
		echo $panelAccordeon;
	}
	echo ' </div>';
}
?>  
				<h3>Spécifications </h3>
<?php
// Récupérer les Badges
$sql1 = "SELECT * FROM CategorieBadge WHERE idCategorie < 8 ORDER BY idCategorie";
$result1 = mysql_query($sql1, $db) or exit(mysql_error() . "<br/>$sql1");

// Afficher les données s'il y en a
if (mysql_num_rows($result1) > 0) {
    while($row1 = mysql_fetch_assoc($result1)) {
        echo '<h4><img src="'.$row1['logoMaster'].'" alt="master '.$row1['idCategorie'].'" style="width:80px"/>'.$row1['theme'].'</h4>';

        // Récupérer les Badges
        $sql = "SELECT * FROM Badge WHERE typeBadge = 'Spécialisation' AND idSection=2 AND idCategorie=".$row1['idCategorie']." ORDER BY idBadge";
        $result = mysql_query($sql, $db) or exit(mysql_error() . "<br/>$sql");

                        // Afficher les données s'il y en a
        if (mysql_num_rows($result) > 0) {
                echo '<div class="panel panel-default"> ';
                while($row = mysql_fetch_assoc($result)) {
                        $panelAccordeon = '<div class="panel-heading"> <h4 class="panel-title">';
                        $panelAccordeon = $panelAccordeon.'<a data-toggle="collapse" data-parent="#accordion" href="#collapseS'.$row['idBadge'].'">'.$row['libelle'].'</a> </h4> </div>';
                        $panelAccordeon = $panelAccordeon.'<div id="collapseS'.$row['idBadge'].'" class="panel-collapse collapse"><div class="panel-body">';
                        $panelAccordeon = $panelAccordeon.'<img src="'.$row['logo'].'" alt="badge engagement" style="float:right; width:100px"/>';
                        $panelAccordeon = $panelAccordeon.$row['description'].'</div> </div> ';
                        echo $panelAccordeon;
                }
                echo ' </div>';
        }
    } // par specialisation : while
} // par specialisation : if
deconnecterBDD($db);
?>  

    
  </div>  

            	
            </div>
            <?php 
            include('piedPage.html');
            ?>
        </div>
    </body>
</html> 

