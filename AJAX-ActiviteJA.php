<?php
    require('utilBDD.php');


    function alterActiviteJA($idActivite, $descCourt, $descLong) {
        $servername = "sql.free.fr";
        $username = "ja.de.pau";
        $password = "Sq7:P@ss";   
        $dbname = "ja_de_pau";

        // Connexion à la BDD
        $db = connecterBDD($servername, $username, $password);
        mysql_select_db($dbname, $db);
        mysql_query("SET NAMES 'utf8'");

        // Récupérer les différentes activités Tisons du futur
        $sql = "UPDATE ActiviteJA SET descCourt='".$descCourt."', descLong='".$descLong."' WHERE idActivite=".$idActivite;
        $result = mysql_query($sql, $db) or exit(mysql_error() . "<br/>$sql");
        if (mysql_query($sql, $db)) {
            echo "Activité mise à jour";
        } else {
            echo "Erreur de mise à jour : " . mysqli_error($conn);
        }
        deconnecterBDD($db);
    }

    function resetActiviteJA($idActivite) {
        $servername = "sql.free.fr";
        $username = "ja.de.pau";
        $password = "Sq7:P@ss";   
        $dbname = "ja_de_pau";

        // Connexion à la BDD
        $db = connecterBDD($servername, $username, $password);
        mysql_select_db($dbname, $db);
        mysql_query("SET NAMES 'utf8'");

        // Récupérer les différentes activités Tisons du futur
        $sql = "UPDATE ActiviteJA SET descCourt='Relâche', descLong=NULL WHERE idActivite=".$idActivite;
        $result = mysql_query($sql, $db) or exit(mysql_error() . "<br/>$sql");
        if (mysql_query($sql, $db)) {
            echo "Activité supprimée";
        } else {
            echo "Erreur de suppression : " . mysqli_error($conn);
        }
        deconnecterBDD($db);
    }
    
    

    function getActiviteJA($idActivite) {
        $servername = "sql.free.fr";
        $username = "ja.de.pau";
        $password = "Sq7:P@ss";   
        $dbname = "ja_de_pau";

        // Connexion à la BDD
        $db = connecterBDD($servername, $username, $password);
        mysql_select_db($dbname, $db);
        mysql_query("SET NAMES 'utf8'");

        // Récupérer les différentes activités Tisons du futur
        $sql = "SELECT descCourt, descLong, idSection FROM ActiviteJA WHERE idActivite=".$idActivite;
        $result = mysql_query($sql, $db) or exit(mysql_error() . "<br/>$sql");
        if (mysql_num_rows($result) > 0) {
            // Affichage des résultats
            while($row = mysql_fetch_assoc($result)) {
                //Debut du message
                if ($row["idSection"] == "1") {
                    echo "<form id='form-".$idActivite."' action='javascript:modifActiviteForm(\"success\",\"form-".$idActivite."\")'><input type='hidden' name='idAct' value='".$idActivite."'>";
                } else if ($row["idSection"] == "2") {
                    echo "<form id='form-".$idActivite."' action='javascript:modifActiviteForm(\"info\",\"form-".$idActivite."\")'><input type='hidden' name='idAct' value='".$idActivite."'>";
                } else if ($row["idSection"] == "3") {
                    echo "<form id='form-".$idActivite."' action='javascript:modifActiviteForm(\"warning\",\"form-".$idActivite."\")'><input type='hidden' name='idAct' value='".$idActivite."'>";
                } 
            
                //Millieu du message
                // Cas de la Relâche :
                if ($row["descCourt"] == "Relâche") {
                    echo "<input type='text' class='form-control' name='descC' value='Activité JA'><br><textarea class='form-control' rows='2' name='descL' placeholder='Description longue (300 caractères) de l activité'></textarea>";
                }
                else {
                    echo "<input type='text' class='form-control' name='descC' value='".$row["descCourt"]."'><br><textarea class='form-control' rows='2' name='descL' placeholder='Description longue (300 caractères) de l activité'>".$row["descLong"]."</textarea>";
                }
                
                //Fin du message
                echo "<br><input type='submit' name='valider' value='Valider'>  </form>";
            }

        } else {
            echo "Erreur de récupération des données : " . mysqli_error($conn);
        }
        deconnecterBDD($db);
    }

    switch($_POST["action"]) {
        case "modif" :
            alterActiviteJA($_POST['idActivite'], $_POST['descCourt'], $_POST['descLong']);
            break;
        case "get" :
            getActiviteJA($_POST['idActivite']);
            break;
        case "reset" :
            resetActiviteJA($_POST['idActivite']);
            break;
        default:
            echo "default";
            break;
    }

?>
