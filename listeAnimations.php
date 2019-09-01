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
            
            
            $servername = "sql.free.fr";
            $username = "ja.de.pau";
            $password = "Sq7:P@ss";   
            $dbname = "ja_de_pau";


            //Si on arrive sur cette page suite à l'ajout d'une animation
            if (isset($_POST['nomA']) && (!empty($_SESSION["user"])) ) {
                print_r($_POST);
                //On recupere chacun des champs pour la BDD
                //idAnimation	
                $dateCreation = date('Y-m-d', time());
                $userCreation = $_SESSION["idUser"];
                $nomA = $_POST['nomA'];
                $arrayType = array(); 
                if (isset($_POST['typeA_int']))
                    $arrayType[] ="interieur ";
                if (isset($_POST['typeA_ext']))
                    $arrayType[] ="exterieur ";
                if (isset($_POST['typeA_jcr']))
                    $arrayType[] ="jeuCourt ";
                if (isset($_POST['typeA_vei']))
                    $arrayType[] ="veillee ";
                if (isset($_POST['typeA_jco']))
                    $arrayType[] ="jeuCoop ";
                if (isset($_POST['typeA_gdj']))
                    $arrayType[] ="grandJeu ";
                $typeA = implode(",",$arrayType);
                //set('interieur','exterieur','veillee','jeuCourt','jeuCoop','grandJeu')
                $ageMin = $_POST['trancheA_min'];
                $ageMax = $_POST['trancheA_max'];
                $duree = $_POST['dureeA'];
                $nbJoueurMin = $_POST['nbJoueurA_min'];
                $nbJoueurMax = $_POST['nbJoueurA_max'];
                $objPeda = $_POST['objPedaA'];
                $objSpi = $_POST['objSpiA'];
                $butJeu = $_POST['butA'];
                $regles = $_POST['regleA'];
                $materiel = $_POST['materielA'];
                $docPJ = "./docAnimation/".$_SESSION["user"]."-".$dateCreation."-".$_FILES['fileToUploadDocumentJeu']['name'];
                if ($_FILES['fileToUploadDocumentJeu']['error']  > 0 ) {
                    echo 'Erreur:'.$_FILES['fileToUploadDocumentJeu']['error'].'<br/>';
                    $docPJ = "";
                } else {
                    $res = move_uploaded_file($_FILES['fileToUploadDocumentJeu']['tmp_name'],$docPJ);
                    echo "Copie Fichier OK <br>";
                }
                
                //On cree en BDD l'animation
            
                $sql = "INSERT INTO Animation(dateCreation, userCreation, nomA, typeA, ageMin, ageMax, duree, nbJoueurMin, nbJoueurMax, objPeda, objSpi, butJeu, regles, materiel, docPJ) VALUES ('$dateCreation', '$userCreation', '$nomA', '$typeA', $ageMin, $ageMax, $duree, $nbJoueurMin, $nbJoueurMax, '$objPeda', '$objSpi', '$butJeu', '$regles', '$materiel', '$docPJ')";
                
                echo "<br>".$sql."<br>";
                
                // Connexion à la BDD
                $db = connecterBDD($servername, $username, $password);
                mysql_select_db($dbname, $db);
                mysql_query("SET NAMES 'utf8'");
                $result = mysql_query($sql, $db) or exit(mysql_error() . "<br/>$sql");
                
                deconnecterBDD($db);
            }
                    

            
            ?>
            <div class="row">
                <div class="panel panel-default">
                    <div class="panel-heading">Filtrer la recherche</div>
                    <div class="panel-body">
                    
                    </div>
                </div>
                <?php
                    if ( (!empty($_SESSION["user"])) && (in_array("WA",explode(',',$_SESSION["droits"]))) ) {
                ?>
                    <a href="ajoutAnimation.php"><span class="glyphicon glyphicon-plus-sign"></span>Créer une fiche d'animation</a>
                <?php
                }
                ?>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Nom de l'animation</th>
                                <th>Durée</th>
                                <th>Age</th>
                                <th>Nombre</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        
                        // Connexion à la BDD
                        $db = connecterBDD($servername, $username, $password);
                        mysql_select_db($dbname, $db);
                        mysql_query("SET NAMES 'utf8'");

                        // Récupérer les différentes activités Tisons du futur
                        $sql = "SELECT * FROM Animation ORDER BY idAnimation";
                        $result = mysql_query($sql, $db) or exit(mysql_error() . "<br/>$sql");

                        // Afficher les données s'il y en a
                        if (mysql_num_rows($result) > 0) {
                            // Affichage des résultats
                            while($row = mysql_fetch_assoc($result)) {
                                echo "<tr><td><a href='afficherAnimation.php?idA=".$row['idAnimation']."'>".$row["nomA"]."</a></td><td>".$row["duree"]." min</td><td>".$row["ageMin"]." - ".$row["ageMax"]." ans</td><td>".$row["nbJoueurMin"]." - ".$row["nbJoueurMax"]." personnes</td></tr>";
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
