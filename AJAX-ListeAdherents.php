<?php
    require('utilBDD.php');


    function alterAdherent($idActivite, $descCourt, $descLong) {
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
            echo "Adherent mise à jour";
        } else {
            echo "Erreur de mise à jour : " . mysqli_error($conn);
        }
        deconnecterBDD($db);
    }

    function delAdherent($idAdherent) {
        $servername = "sql.free.fr";
        $username = "ja.de.pau";
        $password = "Sq7:P@ss";   
        $dbname = "ja_de_pau";

        // Connexion à la BDD
        $db = connecterBDD($servername, $username, $password);
        mysql_select_db($dbname, $db);
        mysql_query("SET NAMES 'utf8'");

        // Récupérer les différentes activités Tisons du futur
        $sql = "DELETE FROM Adherent WHERE idAdherent=".$idAdherent;
        $result = mysql_query($sql, $db) or exit(mysql_error() . "<br/>$sql");
        if (mysql_query($sql, $db)) {
            echo "Adhérent supprimé";
        } else {
            echo "Erreur de suppression : " . mysqli_error($conn);
        }
        deconnecterBDD($db);
    }

    switch($_POST["action"]) {
        case "modif" :
            alterActiviteJA($_POST['idActivite'], $_POST['descCourt'], $_POST['descLong']);
            break;
        case "del" :
            delAdherent($_POST['idAdherent']);
            break;
        default:
            echo "default";
            break;
    }

?>