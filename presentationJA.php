<?php
// Start the session
session_start();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html lang="fr">
    <head>
        <meta http-equiv="refresh" content="900">
        <title>JA de PAU </title>   
        <meta name="description" content="Planning et badge des JA de Pau">
        <meta name="keywords" content="JA, PAU, Badge">
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
            ?>
            
            <div class="row">
                <div class="col-sm-12">
                    <div class="panel panel-info">
                        <div class="panel-heading"><b>La "JA" en bref</b></div>
                        
                        <div class="panel-body">
                            <p>La Jeunesse Adventiste veut favoriser une rencontre personnelle, directe, simple de chaque jeune avec Jésus.</p>
                            <ul>
                                <li> Elle veut aider le jeune à inscrire cette rencontre dans le vécu de son quotidien.</li>
                                <li> Elle veut motiver les jeunes pour qu'ils deviennent des citoyens engagés dans la société pour la bonifier.</li>
                                <li> Elle veut les encourager à prendre une part active dans l'église qu'ils fréquentent afin de la dynamiser encore plus.</li>
                                <li> Elle veut permettre à chacun de se développer tant physiquement que psychologiquement, de découvrir et affermir ses aptitudes afin de les mettre au service des autres.</li>
                                <li> Elle veut faire le maximum pour que les jeunes prennent conscience de l'enjeu écologique actuel et qu'ils deviennent acteurs dans ce monde pour le bien de la nature, donc de l'humanité, rentrant ainsi dans les plans du Dieu créateur pour l'homme.</li>
                                <li>Pour mettre en place tout cela, des méthodes actives sont mises en place dans le respect de chacun.</li>
                            </ul>
                            <p>Lien : <a href="http://ffs.adventiste.org/jeunesse-adventiste/">Eglise adventiste du 7e jour : Fédération France Sud - Jeunesse Adventiste</a></p>
                        </div>      
                    </div>
                </div>
            </div>
            <?php 
            include('piedPage.html');
            ?>
        </div>
    </body>
</html> 

