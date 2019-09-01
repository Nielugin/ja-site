<?php
// Start the session
session_start();

// Transforme la liste de type BDD en une liste de type "française"
function typeAnimationToString($bdd_typeA) {
    $arrayType = explode(",",$bdd_typeA);
    $typeRes = equivalenceTypeJeu($arrayType[0]);
    $sizeArrayType = sizeof($arrayType);
    for ($i=1; $i<$sizeArrayType; $i++) {
        $typeRes .= ", ".equivalenceTypeJeu($arrayType[$i]);
    }
    return $typeRes;
}

// Transforme le type de jeu stocké en BDD en chaine "française"
// BDD : 'interieur','exterieur','veillee','jeuCourt','jeuCoop','grandJeu'
function equivalenceTypeJeu($typeJeu) {
    if (strcmp($typeJeu,"interieur") == 0) {
        return "intérieur";
    }
    if (strcmp($typeJeu,"exterieur") == 0) {
        return "extérieur";
    }
    if (strcmp($typeJeu,"veillee") == 0) {
        return "veillée";
    }
    if (strcmp($typeJeu,"jeuCourt") == 0) {
        return "jeu court";
    }
    if (strcmp($typeJeu,"jeuCoop") == 0) {
        return "jeu coopératif";
    }
    if (strcmp($typeJeu,"grandJeu") == 0) {
        return "grand jeu";
    }
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
                    if (!isset($_GET[idA]) ) {
                        header('Location: http://ja.de.pau.free.fr/listeAnimations.php');
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
                        $sql = "SELECT * FROM Animation WHERE idAnimation = ".$_GET[idA];
                        $result = mysql_query($sql, $db) or exit(mysql_error() . "<br/>$sql");
                        
                        // Récupère les données s'il y en a
                        if (mysql_num_rows($result) == 1) {
                            $animation = mysql_fetch_assoc($result);
                        } else {
                            // S'il y a plus d'une animation, c'est qu'il y a un problème.
                            // On redirige vers la page de liste des Animations
                            header('Location: http://ja.de.pau.free.fr/listeAnimations.php');
                        }
                    ?>
                    <div class="panel-heading"><h2><?php echo $animation['nomA']; ?> </h2>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-2"><b>Durée</b> : <?php echo $animation['duree']; ?> min</div>
                            <div class="col-sm-2"><b>Age</b> : <?php echo $animation['ageMin']." - ".$animation['ageMax']; ?> ans</div>
                            <div class="col-sm-3"><b>Nombre</b> : <?php echo $animation['nbJoueurMin']." - ".$animation['nbJoueurMax']; ?> personnes</div>
                            <div class="col-sm-5"><b>Type</b> : <?php echo typeAnimationToString($animation['typeA']); ?></div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12"><b>Objectif pédagogique</b> : <?php echo $animation['objPeda']; ?></div>
                            <div class="col-sm-12"><b>Objectif spirituel</b> : <?php echo $animation['objSpi']; ?></div>
                        </div>
                        <h3>But du jeu</h3>
                        <p><?php echo nl2br($animation['butJeu']); ?></p>
                        <h3>Règles du jeu</h3>
                        <p><?php echo nl2br($animation['regles']); ?></p>
                        <?php 
                        if ($animation['docPJ'] != "") {
                        ?>
                            <br><a target="_blank" rel="noopener noreferrer" href="<?php echo $animation['docPJ']; ?>"> <span class="glyphicon glyphicon-download"></span> Document complémentaire </a>
                        <?
                        }
                        ?>
                        <h3>Matériel</h3>
                        <p><?php echo nl2br($animation['materiel']); ?></p>
                        <a href="listeAnimations.php"><span class="glyphicon glyphicon-menu-left"></span> Retour à la liste d'animation </a>
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
