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
                <div class="panel panel-default">
                    <div class="panel-heading">Filtrer la recherche</div>
                    <div class="panel-body">
                    
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Nom de l'animation</th>
                                <th>Durée</th>
                                <th>Age</th>
                                <th>Type</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        $servername = "sql.free.fr";
                        $username = "ja.de.pau";
                        $password = "Sq7:P@ss";   
                        $dbname = "ja_de_pau";
                        
                        // Connexion à la BDD
                        $db = connecterBDD($servername, $username, $password);
                        mysql_select_db($dbname, $db);
                        mysql_query("SET NAMES 'utf8'");

                        // Récupérer les différentes activités Tisons du futur
                        $sql = "SELECT * FROM Animation";
                        $result = mysql_query($sql, $db) or exit(mysql_error() . "<br/>$sql");

                        // Afficher les données s'il y en a
                        if (mysql_num_rows($result) > 0) {
                            // Affichage des résultats
                            while($row = mysql_fetch_assoc($result)) {
                                echo "<tr><td>".$row["nom"]."</td><td>".$row["duree"]."</td><td>".$row["age"]."</td><td>".$row["type"]."</td></tr>";
                            }
                        }
                        deconnecterBDD($db);
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php 
            include('piedPage.html');
            ?>
        </div>
    </body>
</html> 
