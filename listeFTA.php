<?php
// Start the session
session_start();

//Verification d'utilisateur connecté
if ( (empty($_SESSION["user"])) || !(in_array("WA",explode(',',$_SESSION["droits"]))) ) {
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
            
            
            $servername = "sql.free.fr";
            $username = "ja.de.pau";
            $password = "Sq7:P@ss";   
            $dbname = "ja_de_pau";


            //Si on arrive sur cette page suite à l'ajout d'une animation
            if (isset($_POST['nomActivite']) && (!empty($_SESSION["user"])) ) {
                //print_r($_POST);
                //On recupere chacun des champs pour la BDD
                //idAnimation	
                $dateCreation = date('Y-m-d', time());
                $userCreation = $_SESSION["idUser"];
                $nomActivite = $_POST['nomActivite'];
                $sqlColumns = "dateCreation, userCreation, nomActivite";
                $sqlValues = "'".$dateCreation."','".$userCreation."','".$nomActivite."'";

                if (isset($_POST['dureeActivite']) && !empty($_POST['dureeActivite'])) {
                    $dureeActivite = $_POST['dureeActivite'];
                    $sqlColumns .= ",dureeActivite";
                    $sqlValues .=",".$dureeActivite;
                }
                if (isset($_POST['zoneActivite']) && !empty($_POST['zoneActivite'])) {
                    $zoneActivite = $_POST['zoneActivite'];
                    $sqlColumns .= ",zoneActivite";
                    $sqlValues .=",'".$zoneActivite."'";
                }
                if (isset($_POST['dateActivite']) && !empty($_POST['dateActivite'])){
                    $dateActivite = $_POST['dateActivite'];
                    $sqlColumns .= ",dateActivite";
                    $sqlValues .=",'".$dateActivite."'";
                }
                $arrayPublic = array(); 
                if (isset($_POST['bourgeons']))
                    $arrayPublic[] =$_POST['bourgeons'];
                if (isset($_POST['tisons']))
                    $arrayPublic[] =$_POST['tisons'];
                if (isset($_POST['explos']))
                    $arrayPublic[] =$_POST['explos'];
                if (isset($_POST['compagnons']))
                    $arrayPublic[] =$_POST['compagnons'];
                if (isset($_POST['ainés']))
                    $arrayPublic[] =$_POST['ainés'];
                $publicVise = implode(",",$arrayPublic);
                if (count($arrayPublic)>0) {
                    $sqlColumns .= ",publicVise";
                    $sqlValues .=",'".$publicVise."'";
                }
                if (isset($_POST['raisonActivite']) && !empty($_POST['raisonActivite'])) {
                    $raisonActivite = $_POST['raisonActivite'];
                    $sqlColumns .= ",raisonActivite";
                    $sqlValues .=",'".$raisonActivite."'";
                }
                if (isset($_POST['texteMedit']) && !empty($_POST['texteMedit'])) {
                    $texteMedit = $_POST['texteMedit'];
                    $sqlColumns .= ",texteMedit";
                    $sqlValues .=",'".$texteMedit."'";
                }
                if (isset($_POST['objectifsVises']) && !empty($_POST['objectifsVises'])) {
                    $objectifsVises = $_POST['objectifsVises'];
                    $sqlColumns .= ",objectifsVises";
                    $sqlValues .=",'".$objectifsVises."'";
                }
                if (isset($_POST['themeActivite']) && !empty($_POST['themeActivite'])) {
                    $themeActivite = $_POST['themeActivite'];
                    $sqlColumns .= ",themeActivite";
                    $sqlValues .=",'".$themeActivite."'";
                }
                if (isset($_POST['typeActivite']) && !empty($_POST['typeActivite'])) {
                    $typeActivite = $_POST['typeActivite'];
                    $sqlColumns .= ",typeActivite";
                    $sqlValues .=",'".$typeActivite."'";
                }
                if (isset($_POST['nombreAnims']) && !empty($_POST['nombreAnims'])) {
                    $nombreAnims = $_POST['nombreAnims'];
                    $sqlColumns .= ",nombreAnims";
                    $sqlValues .=",'".$nombreAnims."'";
                }
                if (isset($_POST['deplacement']) && !empty($_POST['deplacement'])) {
                    $deplacement = 0;
                    if ($_POST['deplacement'] == "oui")
                        $deplacement = 1;
                    $sqlColumns .= ",deplacement";
                    $sqlValues .=",".$deplacement;
                }
                if (isset($_POST['fonctionnementEn']) && !empty($_POST['fonctionnementEn'])) {
                    $fonctionnementEn = $_POST['fonctionnementEn'];
                    $sqlColumns .= ",fonctionnementEn";
                    $sqlValues .=",'".$fonctionnementEn."'";
                }
                if (isset($_POST['constitutionEquipe']) && !empty($_POST['constitutionEquipe'])) {
                    $constitutionEquipe = $_POST['constitutionEquipe'];
                    if ($constitutionEquipe == "autre")
                        $constitutionEquipe = $_POST['constitutionAutre'];
                    $sqlColumns .= ",constitutionEquipe";
                    $sqlValues .=",'".$constitutionEquipe."'";
                }
                if (isset($_POST['lieuDebutActivite']) && !empty($_POST['lieuDebutActivite'])) {
                    $lieuDebutActivite = $_POST['lieuDebutActivite'];
                    if ($lieuDebutActivite == "autre")
                        $lieuDebutActivite = $_POST['lieuDebutAutre'];
                    $sqlColumns .= ",lieuDebutActivite";
                    $sqlValues .=",'".$lieuDebutActivite."'";
                }
                if (isset($_POST['lieuFinActivite']) && !empty($_POST['lieuFinActivite'])) {
                    $lieuFinActivite = $_POST['lieuFinActivite'];
                    if ($lieuFinActivite == "autre")
                        $lieuFinActivite = $_POST['lieuFinAutre'];
                    $sqlColumns .= ",lieuFinActivite";
                    $sqlValues .=",'".$lieuFinActivite."'";
                }
                if (isset($_POST['typeDeFin']) && !empty($_POST['typeDeFin'])) {
                    $typeDeFin = $_POST['typeDeFin'];
                    if ($typeDeFin == "autre")
                        $typeDeFin = $_POST['finAutre'];
                    $sqlColumns .= ",typeDeFin";
                    $sqlValues .=",'".$typeDeFin."'";
                }
                if (isset($_POST['trameGenerale']) && !empty($_POST['trameGenerale'])) {
                    $trameGenerale = $_POST['trameGenerale'];
                    $sqlColumns .= ",trameGenerale";
                    $sqlValues .=",'".$trameGenerale."'";
                }
                if (isset($_POST['deroulementActivite']) && !empty($_POST['deroulementActivite'])) {
                    $deroulementActivite = $_POST['deroulementActivite'];
                    $sqlColumns .= ",deroulementActivite";
                    $sqlValues .=",'".$deroulementActivite."'";
                }
                if (isset($_POST['materiel']) && !empty($_POST['materiel'])) {
                    $materiel = $_POST['materiel'];
                    $sqlColumns .= ",materiel";
                    $sqlValues .=",'".$materiel."'";
                }
                $docPJ = "./docAnimation/".$_SESSION["user"]."-".$dateCreation."-".$_FILES['fileToUploadDocumentJeu']['name'];
                if ($_FILES['fileToUploadDocumentJeu']['error']  > 0 ) {
                    echo 'Erreur:'.$_FILES['fileToUploadDocumentJeu']['error'].'<br/>';
                    $docPJ = "";
                } else {
                    $res = move_uploaded_file($_FILES['fileToUploadDocumentJeu']['tmp_name'],$docPJ);
                    echo "Copie Fichier OK <br>";
                }
                
                //On cree en BDD l'animation
            
                $sql = "INSERT INTO FicheTechniqueAnimation(".$sqlColumns.", docPJ) VALUES (".$sqlValues.", '$docPJ')";
                
                //echo "<br>".$sql."<br>";
                
                // Connexion à la BDD
                $db = connecterBDD($servername, $username, $password);
                mysql_select_db($dbname, $db);
                mysql_query("SET NAMES 'utf8'");
                $result = mysql_query($sql, $db) or exit(mysql_error() . "<br/>$sql");
                
                deconnecterBDD($db);
            }
                    

            
            ?>
            <div class="row">
                <?php
                /*
                <div class="panel panel-default">
                    <div class="panel-heading">Filtrer la recherche</div>
                    <div class="panel-body">
                    
                    </div>
                </div>
                */
                ?>
                <?php
                    if ( (!empty($_SESSION["user"])) && (in_array("WA",explode(',',$_SESSION["droits"]))) ) {
                ?>
                    <a href="newFTA.php"><span class="glyphicon glyphicon-plus-sign"></span>Créer une fiche technique d'animation</a>
                <?php
                }
                ?>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Nom de l'animation</th>
                                <th><img class="img-responsive" src="images/icons8-time.png" alt="Durée"/></th>
                                <th><img class="img-responsive" src="images/icons8-age.png" alt="Age"/></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        
                        // Connexion à la BDD
                        $db = connecterBDD($servername, $username, $password);
                        mysql_select_db($dbname, $db);
                        mysql_query("SET NAMES 'utf8'");

                        // Récupérer les différentes activités Tisons du futur
                        $sql = "SELECT * FROM FicheTechniqueAnimation ORDER BY idFTA";
                        $result = mysql_query($sql, $db) or exit(mysql_error() . "<br/>$sql");

                        // Afficher les données s'il y en a
                        if (mysql_num_rows($result) > 0) {
                            // Affichage des résultats
                            while($row = mysql_fetch_assoc($result)) {
                                $tabPublicVise = explode(",",$row["publicVise"]);
                                $publicVise = "";
                                foreach($tabPublicVise as $pv) {
                                    $publicVise.=",".$pv[0];
                                }
                                $publicVise[0]=' ';
                                echo "<tr><td><a href='afficherFTA.php?idFTA=".$row['idFTA']."'>".$row["nomActivite"]."</a></td><td>".$row["dureeActivite"]." min</td><td>".$publicVise."</td></tr>";
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
