<?php
// Start the session
session_start();

//Verification d'utilisateur connecté
if (empty($_SESSION["user"])) {
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
        
        <script>
            function newAdherent() {
                window.location.replace("inscription.php");
            }
            
            function modifAdherent(idAdherent) {
                window.location.replace("inscription.php?adh="+idAdherent);
            }
            
            function delAdh(idAdh) {
                if (window.XMLHttpRequest) {
                    // code for IE7+, Firefox, Chrome, Opera, Safari
                    xmlhttp = new XMLHttpRequest();
                } else {
                    // code for IE6, IE5
                    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                }
                xmlhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        alert(this.responseText);
                        location.reload();
                    }
                };
                xmlhttp.open("POST","AJAX-ListeAdherents.php",true);
                xmlhttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded;charset=utf-8');
                xmlhttp.send("action=del&idAdherent="+idAdh);
            }
            
            function delAdherent(idAdherent, nomAdherent, prenomAdherent) {
                var res = confirm("Voulez-vous vraiment supprimer l'adhérent "+nomAdherent+" "+prenomAdherent+" ?");
                if (res) { // supprimer l'adhérent
                    //alert("Supprimer Adherent");
                    delAdh(idAdherent);
                }
            }
        </script>
        
    </head>
    <body>
        <div class="container">
            <?php 
            include('entete.html');
            ?>
            <?php 
            include('barreNav.php');
            ?>
            <?php
                // Cas de l'inscription d'un adhérent
            ?>
            <div class="row">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>NOM</th>
                                <th>Prénom</th>
                                <th>Email</th>
                                <th>Téléphone</th>
                                <?php 
                                    if ($_SESSION["droits"] == "RJ") {
                                ?>
                                <th colspan=2>Adresse</th> <th> <button id="addAdh" type="button" class="btn btn-success" onclick="newAdherent()"><span class="glyphicon glyphicon-plus-sign" style="padding-right:3px"></span> <span class="glyphicon glyphicon-user"></span></button></th>
                                <?php 
                                    } else {
                                ?>
                                <th colspan=2>Adresse</th>
                                <?php 
                                    }
                                ?>
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
                        $sql = "SELECT * FROM Adherent, Adresse WHERE adresse = idAdresse ORDER BY nom, prenom";
                        $result = mysql_query($sql, $db) or exit(mysql_error() . "<br/>$sql");

                        // Afficher les données s'il y en a
                        if (mysql_num_rows($result) > 0) {
                            // Affichage des résultats
                            while($row = mysql_fetch_assoc($result)) {
                                echo "<tr><td>".$row["nom"]."</td><td>".$row["prenom"]."</td><td>".$row["email"]."</td><td>".$row["numeroTel"]."</td>";
                                // Cas du RJ
                                if ($_SESSION["droits"] == "RJ") {
                                    // Cas de l'adhérent mineur
                                    if (($row["idPere"] >0) || ($row["idMere"] >0)) {
                                        echo "<td>".$row["adressePostale"]." - ".$row["adresseCP"]." ".$row["adresseVille"]."</td><td>";
                                        if ($row["idPere"] >0) {
                                            // requête des informations du père
                                            $sqlPere = "SELECT * FROM Parent, Adresse WHERE adresse = idAdresse AND idParent = ".$row["idPere"];
                                            $resultPere = mysql_query($sqlPere, $db) or exit(mysql_error() . "<br/>$sqlPere");
                                        
                                            echo '<button type="button" class="btn btn-homme"  data-toggle="modal" data-target="#myModalPere'.$row["idPere"].'" ><span class="glyphicon glyphicon-user"></span></button>';
                                            echo '<!-- Modal -->
<div id="myModalPere'.$row["idPere"].'" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">'.$row["nom"].' '.$row["prenom"].' -  Père</h4>
      </div>
      <div class="modal-body"><p>';
      while($rowPere = mysql_fetch_assoc($resultPere)) {
        echo '<b> NOM </b> : '.$rowPere["nom"].'<br/>';
        echo '<b> Prénom </b> : '.$rowPere["prenom"].'<br/>';
        echo '<b> Adresse </b> : '.$rowPere["adressePostale"]." - ".$rowPere["adresseCP"]." ".$rowPere["adresseVille"].'<br/>';
        if (strlen($rowPere["email"])>0) {
            echo '<b> Email </b> : '.$rowPere["email"].'<br/>';
        }
        if (strlen($rowPere["numeroTel"])>0) {
            echo '<b> Téléphone </b> : '.$rowPere["numeroTel"].'<br/>';
        }
      }
echo '</p></div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>';
                                        }
                                        if ($row["idMere"] >0) {
                                            // requête des informations du père
                                            $sqlMere = "SELECT * FROM Parent, Adresse WHERE adresse = idAdresse AND idParent = ".$row["idMere"];
                                            $resultMere = mysql_query($sqlMere, $db) or exit(mysql_error() . "<br/>$sqlMere");
                                        
                                            echo '<button type="button" class="btn btn-femme"  data-toggle="modal" data-target="#myModalMere'.$row["idMere"].'"><span class="glyphicon glyphicon-user"></span></span></button>';
                                            echo '<!-- Modal -->
<div id="myModalMere'.$row["idMere"].'" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">'.$row["nom"].' '.$row["prenom"].' -  Mère</h4>
      </div>
      <div class="modal-body"><p>';
      while($rowMere = mysql_fetch_assoc($resultMere)) {
        echo '<b> NOM </b> : '.$rowMere["nom"].'<br/>';
        echo '<b> Prénom </b> : '.$rowMere["prenom"].'<br/>';
        echo '<b> Adresse </b> : '.$rowMere["adressePostale"]." - ".$rowMere["adresseCP"]." ".$rowMere["adresseVille"].'<br/>';
        if (strlen($rowMere["email"])>0) {
            echo '<b> Email </b> : '.$rowMere["email"].'<br/>';
        }
        if (strlen($rowMere["numeroTel"])>0) {
            echo '<b> Téléphone </b> : '.$rowMere["numeroTel"].'<br/>';
        }
      }
echo '</p></div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>';
                                        }
                                        echo '</td><td><button type="button" class="btn btn-warning" onclick="modifAdherent(\''.$row["idAdherent"].'\')"><span class="glyphicon glyphicon-pencil"></span></button><button type="button" class="btn btn-danger" onclick="delAdherent(\''.$row["idAdherent"].'\',\''.$row["nom"].'\',\''.$row["prenom"].'\')"><span class="glyphicon glyphicon-trash"></span></button> </td></tr>';
                                    } else {
                                        echo "<td colspan=2>".$row["adressePostale"]." - ".$row["adresseCP"]." ".$row["adresseVille"];
                                        echo '</td><td><button type="button" class="btn btn-warning" onclick="modifAdherent(\''.$row["idAdherent"].'\')"><span class="glyphicon glyphicon-pencil"></span></button><button type="button" class="btn btn-danger" onclick="delAdherent(\''.$row["idAdherent"].'\',\''.$row["nom"].'\',\''.$row["prenom"].'\')"><span class="glyphicon glyphicon-trash"></span></button> </td></tr>';
                                    }
                                // Cas des non RJ : peut voir seulement les informations
                                } else {
                                    // Cas de l'adhérent mineur
                                    if (($row["idPere"] >0) || ($row["idMere"] >0)) {
                                        echo "<td>".$row["adressePostale"]." - ".$row["adresseCP"]." ".$row["adresseVille"]."</td><td>";
                                        if ($row["idPere"] >0) {
                                            // requête des informations du père
                                            $sqlPere = "SELECT * FROM Parent, Adresse WHERE adresse = idAdresse AND idParent = ".$row["idPere"];
                                            $resultPere = mysql_query($sqlPere, $db) or exit(mysql_error() . "<br/>$sqlPere");
                                        
                                            echo '<button type="button" class="btn btn-homme"  data-toggle="modal" data-target="#myModalPere'.$row["idPere"].'" ><span class="glyphicon glyphicon-user"></span></button>';
                                            echo '<!-- Modal -->
<div id="myModalPere'.$row["idPere"].'" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">'.$row["nom"].' '.$row["prenom"].' -  Père</h4>
      </div>
      <div class="modal-body"><p>';
      while($rowPere = mysql_fetch_assoc($resultPere)) {
        echo '<b> NOM </b> : '.$rowPere["nom"].'<br/>';
        echo '<b> Prénom </b> : '.$rowPere["prenom"].'<br/>';
        echo '<b> Adresse </b> : '.$rowPere["adressePostale"]." - ".$rowPere["adresseCP"]." ".$rowPere["adresseVille"].'<br/>';
        if (strlen($rowPere["email"])>0) {
            echo '<b> Email </b> : '.$rowPere["email"].'<br/>';
        }
        if (strlen($rowPere["numeroTel"])>0) {
            echo '<b> Téléphone </b> : '.$rowPere["numeroTel"].'<br/>';
        }
      }
echo '</p></div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>';
                                        }
                                        if ($row["idMere"] >0) {
                                            // requête des informations du père
                                            $sqlMere = "SELECT * FROM Parent, Adresse WHERE adresse = idAdresse AND idParent = ".$row["idMere"];
                                            $resultMere = mysql_query($sqlMere, $db) or exit(mysql_error() . "<br/>$sqlMere");
                                        
                                            echo '<button type="button" class="btn btn-femme"  data-toggle="modal" data-target="#myModalMere'.$row["idMere"].'"><span class="glyphicon glyphicon-user"></span></span></button>';
                                            echo '<!-- Modal -->
<div id="myModalMere'.$row["idMere"].'" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">'.$row["nom"].' '.$row["prenom"].' -  Mère</h4>
      </div>
      <div class="modal-body"><p>';
      while($rowMere = mysql_fetch_assoc($resultMere)) {
        echo '<b> NOM </b> : '.$rowMere["nom"].'<br/>';
        echo '<b> Prénom </b> : '.$rowMere["prenom"].'<br/>';
        echo '<b> Adresse </b> : '.$rowMere["adressePostale"]." - ".$rowMere["adresseCP"]." ".$rowMere["adresseVille"].'<br/>';
        if (strlen($rowMere["email"])>0) {
            echo '<b> Email </b> : '.$rowMere["email"].'<br/>';
        }
        if (strlen($rowMere["numeroTel"])>0) {
            echo '<b> Téléphone </b> : '.$rowMere["numeroTel"].'<br/>';
        }
      }
echo '</p></div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>';
                                        }
                                        echo "</td></tr>";
                                    } else {
                                        echo "<td colspan=2>".$row["adressePostale"]." - ".$row["adresseCP"]." ".$row["adresseVille"]."</td></tr>";
                                    }
                                }
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
