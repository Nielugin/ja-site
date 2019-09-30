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
        
        function alterAct(idAct, descC, descL) {
            if (window.XMLHttpRequest) {
                // code for IE7+, Firefox, Chrome, Opera, Safari
                xmlhttp = new XMLHttpRequest();
            } else {
                // code for IE6, IE5
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    var classAlert = "success";
                    if (this.responseText.indexOf("Erreur") >= 0) {
                        classAlert = "danger";
                    } 
                    document.getElementById("msgGeneral").innerHTML += '<div class="alert alert-'+classAlert+'">'+this.responseText+'</div>';
                }
            };
            xmlhttp.open("POST","AJAX-ActiviteJA.php",true);
            xmlhttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded;charset=utf-8');
            xmlhttp.send("action=modif&idActivite="+idAct+"&descCourt="+descC+"&descLong="+descL);
        }
        
        function getAct(idAct) {
            if (window.XMLHttpRequest) {
                // code for IE7+, Firefox, Chrome, Opera, Safari
                xmlhttp = new XMLHttpRequest();
            } else {
                // code for IE6, IE5
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById(idAct).innerHTML = this.responseText;
                }
            };
            xmlhttp.open("POST","AJAX-ActiviteJA.php",false);
            xmlhttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded;charset=utf-8');
            xmlhttp.send("action=get&idActivite="+idAct);
        }
        
        function resetAct(idAct) {
            if (window.XMLHttpRequest) {
                // code for IE7+, Firefox, Chrome, Opera, Safari
                xmlhttp = new XMLHttpRequest();
            } else {
                // code for IE6, IE5
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    var classAlert = "success";
                    if (this.responseText.indexOf("Erreur") >= 0) {
                        classAlert = "danger";
                    } 
                    document.getElementById("msgGeneral").innerHTML += '<div class="alert alert-'+classAlert+'">'+this.responseText+'</div>';
                }
            };
            xmlhttp.open("POST","AJAX-ActiviteJA.php",true);
            xmlhttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded;charset=utf-8');
            xmlhttp.send("action=reset&idActivite="+idAct);
        }
        
        function modifActivite(idAct) {
            getAct(idAct);
        }
        
        function modifActiviteForm(panelClass,formAct) {
            var id = document.getElementById(formAct).idAct.value;
            alterAct(document.getElementById(formAct).idAct.value, document.getElementById(formAct).descC.value, document.getElementById(formAct).descL.value);
            
            document.getElementById(id).innerHTML=document.getElementById(formAct).descC.value+"<br/>"+document.getElementById(formAct).descL.value;
            document.getElementById(id).parentNode.className="panel panel-"+panelClass;
        }
         
        
        function resetActivite(idAct) {
            if (confirm("Voulez-vous vraiment supprimer l'activité JA?")) {
                resetAct(idAct);
                document.getElementById(idAct).innerHTML="Relâche<br/>";
                document.getElementById(idAct).parentNode.className="panel panel-default";
            }
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
                <div id="msgGeneral"><p><em>Les plannings peuvent être amenés à évoluer </em></p></div>
                <div class="col-sm-4">
                <h2>Prochaines activités Tisons</h2>

                <?php
// Connexion à la BDD
$db = connecterBDD($servername, $username, $password);
mysql_select_db($dbname, $db);
mysql_query("SET NAMES 'utf8'");

// Récupérer les différentes activités Tisons du futur
$sql = "SELECT * FROM ActiviteJA NATURAL JOIN SectionJA WHERE libelle='tison' AND dateSamedi >= cast(now() as date) ORDER BY dateSamedi ";
$result = mysql_query($sql, $db) or exit(mysql_error() . "<br/>$sql");

// Afficher les données s'il y en a
if (mysql_num_rows($result) > 0) {
    // Affichage des résultats
    while($row = mysql_fetch_assoc($result)) {
        // Cas de la Relâche :
        if ($row["descCourt"] == "Relâche") {
            $panelClass = 'panel-default';
        } else {
            $panelClass = 'panel-success';
        }
        
        $activiteJA = '<div class="panel '.$panelClass.'">';
        $activiteJA = $activiteJA.'<div class="panel-heading">'.transformerDate($row["dateSamedi"]);
        // si la personne est connectée avec les bons droits
        if ((!empty($_SESSION["droits"])) && ((in_array("RJ",explode(',',$_SESSION["droits"]))) || (in_array("RT",explode(',',$_SESSION["droits"]))) || (in_array("AT",explode(',',$_SESSION["droits"]))))) {
            $activiteJA = $activiteJA.' <button style="float: right" type="button" class="btn btn-danger" onclick="resetActivite(\''.$row["idActivite"].'\')"><span class="glyphicon glyphicon-trash"></span></button>';
            $activiteJA = $activiteJA.' <button style="float: right" type="button" class="btn btn-warning" onclick="modifActivite(\''.$row["idActivite"].'\')"><span class="glyphicon glyphicon-pencil"></span></button> ';
                    }
        $activiteJA = $activiteJA.'</div><div id="'.$row["idActivite"].'" class="panel-body">'.$row["descCourt"].'<br/>';
        if ($row["descLong"] != "NULL") {
            $activiteJA = $activiteJA.$row["descLong"];
        }
        $activiteJA = $activiteJA.'</div></div>';
        echo $activiteJA;
    }
}

deconnecterBDD($db);
?>
                </div>
		
		<div class="col-sm-4">
                <h2>Prochaines activités Explos </h2>
<!--Format des activités-->
<!--<div class="panel panel-default">
  <div class="panel-heading">Panel Heading</div>
  <div class="panel-body">Panel Content</div>
</div>-->
                
                <?php
// Connexion à la BDD
$db = connecterBDD($servername, $username, $password);
mysql_select_db($dbname, $db);
mysql_query("SET NAMES 'utf8'");

// Récupérer les différentes activités Tisons du futur
$sql = "SELECT * FROM ActiviteJA NATURAL JOIN SectionJA WHERE libelle='explorateur' AND dateSamedi >= cast(now() as date) ORDER BY dateSamedi ";
$result = mysql_query($sql, $db) or exit(mysql_error() . "<br/>$sql");;

// Afficher les données s'il y en a
if (mysql_num_rows($result) > 0) {
    // Affichage des résultats
    while($row = mysql_fetch_assoc($result)) {
        // Cas de la Relâche :
        if ($row["descCourt"] == "Relâche") {
            $panelClass = 'panel-default';
        } else {
            $panelClass = 'panel-info';
        }
        
        $activiteJA = '<div class="panel '.$panelClass.'">';
        $activiteJA = $activiteJA.'<div class="panel-heading">'.transformerDate($row["dateSamedi"]);
        // si la personne est connectée avec les bons droits
        if ((!empty($_SESSION["droits"])) && ((in_array("RJ",explode(',',$_SESSION["droits"]))) || (in_array("RE",explode(',',$_SESSION["droits"]))) || (in_array("AE",explode(',',$_SESSION["droits"]))))) {
            $activiteJA = $activiteJA.' <button style="float: right" type="button" class="btn btn-danger" onclick="resetActivite(\''.$row["idActivite"].'\')"><span class="glyphicon glyphicon-trash"></span></button>';
            $activiteJA = $activiteJA.' <button style="float: right" type="button" class="btn btn-warning" onclick="modifActivite(\''.$row["idActivite"].'\')"><span class="glyphicon glyphicon-pencil"></span></button> ';
                    }
        $activiteJA = $activiteJA.'</div><div id="'.$row["idActivite"].'" class="panel-body">'.$row["descCourt"].'<br/>';
        if ($row["descLong"] != "NULL") {
            $activiteJA = $activiteJA.$row["descLong"];
        }
        $activiteJA = $activiteJA.'</div></div>';
        echo $activiteJA;
    }
}

deconnecterBDD($db);
?>
                
                </div>
                <div class="col-sm-4">
                <h2>Prochaines activités Ambassadeurs <!-- Compagnons--> </h2>
<!--Format des activités-->
<!--<div class="panel panel-default">
  <div class="panel-heading">Panel Heading</div>
  <div class="panel-body">Panel Content</div>
</div>-->
                
                <?php
// Connexion à la BDD
$db = connecterBDD($servername, $username, $password);
mysql_select_db($dbname, $db);
mysql_query("SET NAMES 'utf8'");

// Récupérer les différentes activités Tisons du futur
$sql = "SELECT * FROM ActiviteJA NATURAL JOIN SectionJA WHERE libelle='compagnon' AND dateSamedi >= cast(now() as date) ORDER BY dateSamedi ";
$result = mysql_query($sql, $db) or exit(mysql_error() . "<br/>$sql");;

// Afficher les données s'il y en a
if (mysql_num_rows($result) > 0) {
    // Affichage des résultats
    while($row = mysql_fetch_assoc($result)) {
        // Cas de la Relâche :
        if ($row["descCourt"] == "Relâche") {
            $panelClass = 'panel-default';
        } else {
            $panelClass = 'panel-warning';
        }
        
        $activiteJA = '<div class="panel '.$panelClass.'">';
        $activiteJA = $activiteJA.'<div class="panel-heading">'.transformerDate($row["dateSamedi"]);
        // si la personne est connectée avec les bons droits
        if ((!empty($_SESSION["droits"])) && ((in_array("RJ",explode(',',$_SESSION["droits"]))) || (in_array("RC",explode(',',$_SESSION["droits"]))) || (in_array("AC",explode(',',$_SESSION["droits"]))))) {
            $activiteJA = $activiteJA.' <button style="float: right" type="button" class="btn btn-danger" onclick="resetActivite(\''.$row["idActivite"].'\')"><span class="glyphicon glyphicon-trash"></span></button>';
            $activiteJA = $activiteJA.' <button style="float: right" type="button" class="btn btn-warning" onclick="modifActivite(\''.$row["idActivite"].'\')"><span class="glyphicon glyphicon-pencil"></span></button> ';
                    }
        $activiteJA = $activiteJA.'</div><div id="'.$row["idActivite"].'" class="panel-body">'.$row["descCourt"].'<br/>';
        if ($row["descLong"] != "NULL") {
            $activiteJA = $activiteJA.$row["descLong"];
        }
        
        $activiteJA = $activiteJA.'</div></div>';
        echo $activiteJA;
    }
}

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
